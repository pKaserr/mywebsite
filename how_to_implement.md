Data Tooltip with notice (hover):
Import: <script src="./js/tooltip.js" defer></script>

```html
<div class="has-tooltip" data-tooltip="Tooltip Text">Hover me</div>
```

Code-Block:

.c-func-pre
.c-func
.c-var
.c-string
.c-return
.c-comment
.c-keyword
.c-number
.c-boolean
.c-null
.c-undefined
.c-exec

```html
<div class="code-box">
  <span class="c-comment">// This is a comment</span>
  <span class="c-keyword">function</span>
  <span class="c-function">myFunction</span>() {
  <span class="c-var">variable</span> <span class="c-operator">=</span>
  <span class="c-number">1</span>; <span class="c-keyword">return</span>
  <span class="c-number">1</span>; }
</div>
```

Chatbox:

php:
require './includes/auth.php';
require './includes/db_connect.php';

script:

<script src="./js/chat.js" defer></script>

$user_name = $\_SESSION['user_name'];

```html
<?php if (!$is_guest) { ?>
<div class="chatbox until-sm-display-none">
  <div class="display-flex flex-justify-between">
    <button class="chatbox__minimize" onclick="minimizeChatBox()">
      Einklappen
    </button>
    <button class="chatbox__toggle" onclick="toggleChatboxSize()">
      Vergrößern
    </button>
  </div>
  <div class="chatbox__display">
    <p class="chatbox__message chatbox__message--left">
      Hi <?php echo htmlspecialchars($user_name); ?>, ich bin PAi.
    </p>
    <p class="chatbox__message chatbox__message--left">
      Ich bin hier um dir Fragen zu Patricks Person und seine Bewerbung zu
      beantworten.
    </p>
  </div>
  <div class="display-flex flex-align-center">
    <input
      type="text"
      class="chatbox__userInput"
      maxlength="500"
      placeholder="Stellen Sie eine Frage und Enter!"
    />
    <span class="chatbox__userInput__counter" id="chat-char-count">0/500</span>
    <button type="text" class="chatbox__btn btn">Senden</button>
  </div>
</div>
<?php } ?>
```

dumb:
// Gibt den Inhalt und Typen der Variable ganz roh aus,
// ohne dass es leicht via CSS verdeckt wird:
echo "<div style='background: red; color: white; padding: 20px; z-index: 9999; position: relative;'>";
var_dump($currentDir);
echo "<br>Absoluter Verzeichnis-Pfad: " . **DIR**;
echo "</div>";

Img

```html
<div class="ai-img-wrapper--multiple mt-1 mb-1">
  <figure style="margin: 0;">
    <img
      src="../assets/png/umbrella_nn.png"
      style="max-width: 50%;"
      alt="Darstellung des einelne Neurons für das Regenschirm-Beispiel."
    />
    <figcaption>
      Darstellung des einzelnen Neurons für das Regenschirm-Beispiel. Links der
      Input (Wolken, Auto, Wochentag), in der Mitte das Neuron und rechts das
      Ergebnis (benötige ich einen Regenschirm?).
    </figcaption>
  </figure>
</div>
```
