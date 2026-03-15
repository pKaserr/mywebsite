# -*- coding: utf-8 -*-
import sys
import math

# Force UTF-8 for output
if sys.stdout.encoding != 'utf-8':
    import io
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def sigmoid(x):
    return 1 / (1 + math.exp(-x))

def run_nn(x1, x2):
    # --- Schicht 1 (Hidden Layer) ---
    # Gewichte für h1 (w1[0]) und h2 (w1[1])
    w1 = [[ 10.0, -10.0], 
        [-10.0,  10.0]]
    bias = [-5.0, -5.0]
    
    # --- Schicht 2 (Output Layer) ---
    # HIER IST DIE KORREKTUR: Eigene Gewichte für das Output-Neuron festlegen
    w2 = [10.0, 10.0]
    bias2 = -5.0

    # --- Berechnung Schicht 1 ---
    h1 = (x1 * w1[0][0]) + (x2 * w1[0][1]) + bias[0]
    h2 = (x1 * w1[1][0]) + (x2 * w1[1][1]) + bias[1]

    a1 = sigmoid(h1)
    a2 = sigmoid(h2)

    # --- Berechnung Schicht 2 ---
    # a1 und a2 fließen als Inputs in das letzte Neuron
    # w2[0] und w2[1] sind die dazugehörigen Gewichte
    result = sigmoid((a1 * w2[0]) + (a2 * w2[1]) + bias2)
    
    return result, a1, a2

if __name__ == "__main__":

    # architecture of the neural network
    # 2 input layer (x1, x2)
    # 1 hidden layer (h1, h2)
    # 1 output layer (y1)
    if len(sys.argv) < 3:
        sys.exit(1)

    try:
        # Get inputs from Command Line Arguments
        cinema = int(sys.argv[1])
        netflix   = int(sys.argv[2])

        prob, h1, h2 = run_nn(cinema, netflix)
        
        print(f"Eingaben: Cinema={cinema}, Netflix={netflix}")
        print(f"Gewichtete Summe (h1): {h1:.2f}")
        print(f"Gewichtete Summe (h2): {h2:.2f}")
        print(f"Wahrscheinlichkeit (Sigmoid): {prob:.4f}")
        
        if prob > 0.5:
            print("Entscheidung: JA, ins Kino gehen!")
        elif prob < 0.5:
            print("Entscheidung: NEIN, zuhause bleiben!")
        else:
            print("Entscheidung: Unentschieden!")

    except ValueError:
        print("Fehler: Argumente müssen Zahlen sein (0 oder 1).")
