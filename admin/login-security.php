<?php
/**
 * Login Security: Bloqueio temporário após várias tentativas de login malsucedidas.
 */

// Remover a mensagem de erro padrão do WordPress
add_filter('login_errors', function() {
  return ''; // Remove mensagens padrão de erro
});

// Função para limitar tentativas de login e exibir mensagens personalizadas
function limit_login_attempts($user, $username) {
  $max_attempts = 4; // Número máximo de tentativas permitidas
  $lockout_time = 15 * MINUTE_IN_SECONDS; // Tempo de bloqueio em segundos (15 minutos)
  $user_ip = $_SERVER['REMOTE_ADDR']; // IP do usuário
  $attempts = get_transient('login_attempts_' . $user_ip);

  // Verifica se o IP está bloqueado
  if ($attempts && $attempts['count'] >= $max_attempts) {
    $remaining_time = $lockout_time - (time() - $attempts['last_attempt']);
    if ($remaining_time > 0) {
      return new WP_Error(
        'too_many_attempts',
        sprintf(
          'Você excedeu o número máximo de tentativas. Tente novamente em %d minutos.',
          ceil($remaining_time / 60)
        )
      );
    } else {
      // Remove o bloqueio após o tempo expirar
      delete_transient('login_attempts_' . $user_ip);
    }
  }

  // Incrementa tentativas em caso de erro de autenticação ou tentativa inválida
  if (is_wp_error($user) || empty($user)) {
    $remaining_attempts = $max_attempts - ($attempts['count'] ?? 0) - 1;

    // Atualiza ou cria o contador de tentativas
    if (!$attempts) {
      $attempts = ['count' => 1, 'last_attempt' => time()];
    } else {
      $attempts['count']++;
      $attempts['last_attempt'] = time();
    }

    set_transient('login_attempts_' . $user_ip, $attempts, $lockout_time);

    // Retorna mensagem genérica de erro com tentativas restantes
    return new WP_Error(
      'login_failed',
      sprintf(
        'Credenciais inválidas. Você tem mais %d tentativa(s) antes do bloqueio.',
        $remaining_attempts
      )
    );
  }

  // Limpa tentativas após login bem-sucedido
  if (!is_wp_error($user)) {
    delete_transient('login_attempts_' . $user_ip);
  }

  return $user;
}
add_filter('authenticate', 'limit_login_attempts', 30, 2);

/********************************************
 * Adicionar botão de reset no painel administrativo
 */
function add_reset_login_attempts_menu() {
  add_submenu_page(
    'tools.php',
    'Resetar Tentativas de Login',
    'Resetar login',
    'manage_options',
    'reset-login-attempts',
    'reset_login_attempts_page'
  );
}
add_action('admin_menu', 'add_reset_login_attempts_menu');

// Página de reset no painel
function reset_login_attempts_page() {
  if (!current_user_can('manage_options')) {
    return;
  }

  // Variáveis para feedback
  $message = '';
  $message_class = 'updated';

  // Reseta todos os IPs se o botão "Resetar Tudo" for clicado
  if (isset($_POST['reset_all_login_attempts'])) {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_login_attempts_%'");
    $message = 'Todas as tentativas de login foram resetadas.';
  }

  // Reseta um IP específico se o botão "Resetar por IP" for clicado
  if (isset($_POST['reset_ip']) && !empty($_POST['ip_address'])) {
    $ip = sanitize_text_field($_POST['ip_address']);
    $transient_name = 'login_attempts_' . $ip;

    if (delete_transient($transient_name)) {
      $message = "As tentativas de login para o IP {$ip} foram resetadas.";
    } else {
      $message = "Nenhum bloqueio encontrado para o IP {$ip}.";
      $message_class = 'error';
    }
  }

  // Página de administração
  echo '<div class="wrap">';
  echo '<h1>Resetar Tentativas de Login</h1>';

  if (!empty($message)) {
    echo "<div class='{$message_class}'><p>{$message}</p></div>";
  }

  echo '<form method="post">';
  echo '<h2>Resetar Todos os Bloqueios</h2>';
  echo '<p>Essa ação removerá todas as restrições de IP por tentativas de login mal-sucedidas.</p>';
  echo '<input type="hidden" name="reset_all_login_attempts" value="1">';
  echo '<button type="submit" class="button-primary">Resetar Tudo</button>';
  echo '</form>';
  echo '<hr style="margin:30px 0;">';
  echo '<form method="post">';
  echo '<h2 style="margin-top:0;">Resetar Bloqueio por IP</h2>';
  echo '<p>Insira o endereço IP para remover o bloqueio.</p>';
  echo '<label for="ip_address">Endereço IP: </label>';
  echo '<input type="text" name="ip_address" id="ip_address" placeholder="123.123.123.123" required>';
  echo '<button type="submit" name="reset_ip" class="button-primary">Resetar por IP</button>';
  echo '</form>';
  echo '</div>';
}
?>