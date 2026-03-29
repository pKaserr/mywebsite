Data Tooltip with notice (hover):
Import: <script src="./js/tooltip.js" defer></script>

```html
<span class="has-tooltip" data-tooltip="Tooltip Text">Hover me</span>
```

Code-Block:

<pre class="code-box"><div class="code-box__copy-btn"><img src="../assets/png/copy_btn.png" alt="Copy Code"></div><code class="language-python">def run_nn(x1, x2):
    # --- Gewichte (weights) ---
    w1 = [[ 10.0, -10.0],  # Erster Layer (Hidden Layer)
          [-10.0,  10.0]]
</code></pre>

````

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
````

dumb:
// Gibt den Inhalt und Typen der Variable ganz roh aus,
// ohne dass es leicht via CSS verdeckt wird:
echo "<div style='background: red; color: white; padding: 20px; z-index: 9999; position: relative;'>";
var_dump($currentDir);
echo "<br>Absoluter Verzeichnis-Pfad: " . **DIR**;
echo "</div>";

Img

```html
<div class="ai-img-wrapper ai-img-wrapper--small mt-1">
  <figure>
    <img src="../assets/png/clustering.png" alt="Clustering" />
    <figcaption>
      Beispiel eines Clusters. Hier werden gleiche Farbe, Anzahl und Formen
      zusammengelegt. Beim Unsupervised Learning werden solche Cluster gefunden.
      Diese können viele Dimensionen haben. Ein Hund hat somit nicht nur den
      eigenen Cluster "Hund" sondern auch Rasse, Tier, Alter, Größe, Farbe und
      sehr viele mehr. Jede Katze gehört somit ebenfalls zum Cluster Tier.
    </figcaption>
  </figure>
</div>
```


Exkurs:

<button class="accordion accordion--bg mt-1 p-1 mb-0">Title des Buttons</button>
<div class="panel">
    <p>Inhalt des Panels</p>
</div>