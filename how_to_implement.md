Data Tooltip with notice (hover):
Import: <script src="./js/tooltip.js" defer></script>

```html
<div class="has-tooltip" data-tooltip='Tooltip Text'>Hover me</div>
```


Code-Block:

```html
<div class="code-block">
    <span class="c-comment">// This is a comment</span>
    <span class="c-keyword">function</span> <span class="c-function">myFunction</span>() {
        <span class="c-keyword">return</span> <span class="c-number">1</span>;
    }
</div>
```

Chatbox:

php:
require './includes/auth.php';
require './includes/db_connect.php';

script:
<script src="./js/chat.js" defer></script>

$user_name = $_SESSION['user_name'];

```html
            <?php if (!$is_guest) { ?>
                <div class="chatbox until-sm-display-none">
                    <div class="display-flex flex-justify-between">
                        <button class="chatbox__minimize" onclick="minimizeChatBox()">Einklappen</button>
                        <button class="chatbox__toggle" onclick="toggleChatboxSize()">Vergrößern</button>
                    </div>
                    <div class="chatbox__display">
                        <p class="chatbox__message chatbox__message--left">Hi <?php echo htmlspecialchars($user_name); ?>,
                            ich bin PAi.</p>
                        <p class="chatbox__message chatbox__message--left">Ich bin hier um dir Fragen zu Patricks Person und
                            seine Bewerbung zu beantworten.</p>
                    </div>
                    <div class="display-flex flex-align-center">
                        <input type="text" class="chatbox__userInput" maxlength="500" placeholder="Stellen Sie eine Frage und Enter!">
                        <span class="chatbox__userInput__counter" id="chat-char-count">0/500</span>
                        <button type="text" class="chatbox__btn btn">Senden</button>
                    </div>
                </div>
            <?php } ?>
```