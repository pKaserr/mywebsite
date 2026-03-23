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
    # --- Gewichte (weights) ---
    w1 = [[ 10.0, -10.0],  # Erster Layer (Hidden Layer)
          [-10.0,  10.0]]
          
    w2 = [[ 10.0, -10.0],  # Zweiter Layer (Output Layer)
          [-10.0,  10.0]] 
          
    bias = [-5.0, -5.0]
    bias2 = [-5.0, -5.0]
    
    # --- Berechnnung der Schicht 1 (Hidden Layer) ---
    hidden_layer_calc_1 = (x1 * w1[0][0]) + (x2 * w1[0][1]) + bias[0]
    hidden_layer_calc_2 = (x1 * w1[1][0]) + (x2 * w1[1][1]) + bias[1]

    hidden_layer_activating_1 = sigmoid(hidden_layer_calc_1)
    hidden_layer_activating_2 = sigmoid(hidden_layer_calc_2)

    # --- Berechnung Schicht 2 (Output Layer) ---
    output_layer_calc_1 = (hidden_layer_activating_1 * w2[0][0]) + (hidden_layer_activating_2 * w2[0][1]) + bias2[0]
    output_layer_calc_2 = (hidden_layer_activating_1 * w2[1][0]) + (hidden_layer_activating_2 * w2[1][1]) + bias2[1]

    output_layer_activating_1 = sigmoid(output_layer_calc_1)
    output_layer_activating_2 = sigmoid(output_layer_calc_2)

    return hidden_layer_calc_1, hidden_layer_calc_2, hidden_layer_activating_1, hidden_layer_activating_2, output_layer_activating_1, output_layer_activating_2, output_layer_calc_1, output_layer_calc_2

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

        hidden_layer_calc_1, hidden_layer_calc_2, hidden_layer_activating_1, hidden_layer_activating_2, output_layer_activating_1, output_layer_activating_2, output_layer_calc_1, output_layer_calc_2 = run_nn(cinema, netflix)
        
        print(f"Eingaben: Cinema={cinema}, Netflix={netflix}")
        print(f"Berechnung des Hidden Layers neuron 1: {hidden_layer_calc_1:.2f}")
        print(f"Berechnung des Hidden Layers neuron 2: {hidden_layer_calc_2:.2f}")
        print(f"Aktivierung des Hidden Layers neuron 1: {hidden_layer_activating_1:.2f}")
        print(f"Aktivierung des Hidden Layers neuron 2: {hidden_layer_activating_2:.2f}")
        print(f"Berechnung des Output Layers neuron 1: {output_layer_calc_1:.2f}")
        print(f"Berechnung des Output Layers neuron 2: {output_layer_calc_2:.2f}")
        print(f"Aktivierung des Output Layers neuron 1 (Kino): {output_layer_activating_1:.2f}")
        print(f"Aktivierung des Output Layers neuron 2 (Netflix): {output_layer_activating_2:.2f}")
        
        if output_layer_activating_1 == output_layer_activating_2:
            print("Entscheidung: Unentschieden!")
        elif output_layer_activating_1 > output_layer_activating_2:
            print("Entscheidung: JA, ins Kino gehen!")
        else:
            print("Entscheidung: NEIN, zuhause bleiben!")

    except ValueError:
        print("Fehler: Argumente müssen Zahlen sein (0 oder 1).")
