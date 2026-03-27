import sys
import random
import math

# --- Hilfsfunktionen ---
def sigmoid(x):
    return 1 / (1 + math.exp(-x))

def sigmoid_derivative(output):
    # Optimiert: Erwartet das bereits berechnete Sigmoid-Ergebnis
    return output * (1.0 - output)

# --- 1. Die Trainings-Funktion ---
def train_nn(epochs=10000, learning_rate=0.5):
    # Zufällige Start-Gewichte und Biases (zwischen -1 und 1)
    w1 = [[random.uniform(-1, 1), random.uniform(-1, 1)],
          [random.uniform(-1, 1), random.uniform(-1, 1)]]
    b1 = [random.uniform(-1, 1), random.uniform(-1, 1)]
    
    w2 = [random.uniform(-1, 1), random.uniform(-1, 1)]
    b2 = random.uniform(-1, 1)

    # Unsere Trainingsdaten (Das XOR-Problem als Beispiel)
    # Format: (Inputs, Gewünschter_Output)
    # [Kino, Netflix], Output
    training_data = [
        ([0, 0], 0), # Weder Kino noch Netflix -> 0
        ([0, 1], 1), # Nur Netflix -> 1
        ([1, 0], 1), # Nur Kino -> 1
        ([1, 1], 0)  # Beides geht nicht -> 0
    ]

    print(f"Starte Training für {epochs} Epochen...\n")
    print("-" * 50)
    
    # Bestimme Ausgabe-Intervall abhängig von der Anzahl der Epochen
    print_interval = max(1, epochs // 10)

    for epoch in range(epochs):
        total_error = 0
        for x, y_true in training_data:
            
            # ==========================================
            # 1. FORWARD PASS
            # ==========================================
            h1 = x[0]*w1[0][0] + x[1]*w1[1][0] + b1[0]
            h2 = x[0]*w1[0][1] + x[1]*w1[1][1] + b1[1]

            a1 = sigmoid(h1)
            a2 = sigmoid(h2)

            z_out = a1*w2[0] + a2*w2[1] + b2
            output = sigmoid(z_out)

            # ==========================================
            # 2. BACKWARD PASS (Der Fehler)
            # ==========================================
            # Wie weit lagen wir daneben?
            error = output - y_true 
            total_error += abs(error)
            
            # Die "Schuld" des Output-Layers am Fehler
            d_output = error * sigmoid_derivative(output)

            # Den Fehler an das Hidden Layer "zurückschieben" (Backpropagation)
            error_h1 = d_output * w2[0]
            error_h2 = d_output * w2[1]

            # Die "Schuld" der Hidden-Neuronen
            d_h1 = error_h1 * sigmoid_derivative(a1)
            d_h2 = error_h2 * sigmoid_derivative(a2)

            # ==========================================
            # 3. GEWICHTE UPDATEN (Gradient Descent)
            # ==========================================
            
            # Update Layer 2 (Output Layer)
            w2[0] -= learning_rate * d_output * a1
            w2[1] -= learning_rate * d_output * a2
            b2    -= learning_rate * d_output

            # Update Layer 1 (Hidden Layer)
            w1[0][0] -= learning_rate * d_h1 * x[0]
            w1[1][0] -= learning_rate * d_h1 * x[1]
            w1[0][1] -= learning_rate * d_h2 * x[0]
            w1[1][1] -= learning_rate * d_h2 * x[1]
            b1[0]    -= learning_rate * d_h1
            b1[1]    -= learning_rate * d_h2

        # Status ausgeben
        if epoch == 0 or (epoch + 1) % print_interval == 0 or epoch == epochs - 1:
            print(f"Epoche {(epoch + 1):5d} / {epochs} | Durchschnittlicher Fehler: {total_error/len(training_data):.5f}")

    print("-" * 50)
    print("\nTraining abgeschlossen!\n")
    return w1, b1, w2, b2

# --- 2. Die Vorhersage-Funktion (Inferenz) ---
def predict(x1, x2, w1, b1, w2, b2):
    # Nur noch ein Forward Pass mit den gelernten Gewichten
    h1 = x1*w1[0][0] + x2*w1[1][0] + b1[0]
    h2 = x1*w1[0][1] + x2*w1[1][1] + b1[1]

    a1 = sigmoid(h1)
    a2 = sigmoid(h2)

    return sigmoid(a1*w2[0] + a2*w2[1] + b2)


if __name__ == "__main__":
    user_x1 = int(sys.argv[1]) if len(sys.argv) > 1 else 0
    user_x2 = int(sys.argv[2]) if len(sys.argv) > 2 else 0
    epochs  = int(sys.argv[3]) if len(sys.argv) > 3 else 10000
    
    trained_w1, trained_b1, trained_w2, trained_b2 = train_nn(epochs=epochs)
    result = predict(user_x1, user_x2, trained_w1, trained_b1, trained_w2, trained_b2)
    
    input_desc = ""
    if user_x1 == 1 and user_x2 == 1:
        input_desc = "Ins Kino gehen UND Netflix schauen"
    elif user_x1 == 1 and user_x2 == 0:
        input_desc = "Nur ins Kino gehen"
    elif user_x1 == 0 and user_x2 == 1:
        input_desc = "Nur Netflix schauen"
    else:
        input_desc = "Weder Kino noch Netflix"
        
    print(f"Eingabe: {input_desc} (Kino={user_x1}, Netflix={user_x2})")
    print(f"Vorhersage-Ergebnis des trainierten Netzes: {result:.4f}")
    if result > 0.5:
        print("=> Fazit: YAY, das ist eine super Kombination! (Ergebnis > 0.5)")
    else:
        print("=> Fazit: Meh, das klappt nicht / ist langweilig. (Ergebnis < 0.5)")