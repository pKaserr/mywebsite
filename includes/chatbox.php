<?php

require './includes/db_connect.php';

$user_name = $_SESSION['user_name'];
$is_guest = isset($_SESSION['is_guest']) && $_SESSION['is_guest'] === true;

if (!$is_guest) {

    ?>
    <script src="./js/chat.js" defer></script>
    <?php
    $chatMinimizedClass = (isset($_COOKIE['chatMinimized']) && $_COOKIE['chatMinimized'] === '1') ? ' chatbox--minimized' : '';
    $minimizeText = (isset($_COOKIE['chatMinimized']) && $_COOKIE['chatMinimized'] === '1') ? 'Ausklappen' : 'Einklappen';
    ?>
    <div class="chatbox until-sm-display-none<?php echo $chatMinimizedClass; ?>">
        <div class="display-flex flex-justify-between">
            <button class="chatbox__minimize" onclick="minimizeChatBox()">
                <?php echo $minimizeText; ?>
            </button>
            <button class="chatbox__toggle" onclick="toggleChatboxSize()">Vergrößern</button>
        </div>
        <div class="chatbox__display">
            <p class="chatbox__message chatbox__message--left">Hi
                <?php echo htmlspecialchars($user_name); ?>,
                ich bin PAi.
            </p>
            <p class="chatbox__message chatbox__message--left">Ich bin hier um dir Fragen zu Patrick und
                seiner Bewerbung zu beantworten.</p>
        </div>
        <div class="display-flex flex-align-center">
            <input type="text" class="chatbox__userInput" maxlength="500" placeholder="Stellen Sie eine Frage und Enter!">
            <span class="chatbox__userInput__counter" id="chat-char-count">0/500</span>
            <button type="text" class="chatbox__btn btn">Senden</button>
        </div>
    </div>
<?php } ?>