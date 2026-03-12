# -*- coding: utf-8 -*-
import sys
import math

# Force UTF-8 for output
if sys.stdout.encoding != 'utf-8':
    import io
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

def sigmoid(x):
    return 1 / (1 + math.exp(-x))

def run_nn(x1, x2, x3):
    # Weights based on the "Umbrella" example
    w1 = 0.8   # Dark clouds
    w2 = 0.0   # Tuesday (not relevant)
    w3 = -0.5  # Driving with car
    bias = 0.1

    # Calculation
    weighted_sum = (x1 * w1) + (x2 * w2) + (x3 * w3) + bias
    result = sigmoid(weighted_sum)
    
    return result, weighted_sum

if __name__ == "__main__":
    if len(sys.argv) < 4:
        print("Fehler: Zu wenige Argumente. Erwartet: weather drive weekday")
        sys.exit(1)

    try:
        # Get inputs from Command Line Arguments
        weather = int(sys.argv[1])
        drive   = int(sys.argv[2])
        weekday = int(sys.argv[3])

        prob, z = run_nn(weather, drive, weekday)
        
        print(f"Eingaben: Bewölkt={weather}, Fahren={drive}, Dienstags={weekday}")
        print(f"Gewichtete Summe (z): {z:.2f}")
        print(f"Wahrscheinlichkeit (Sigmoid): {prob:.4f}")
        
        if prob >= 0.5:
            print("Entscheidung: JA, nimm einen Regenschirm mit!")
        else:
            print("Entscheidung: NEIN, du brauchst keinen Regenschirm.")

    except ValueError:
        print("Fehler: Argumente müssen Zahlen sein (0 oder 1).")
