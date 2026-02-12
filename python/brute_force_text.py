import requests
import time
import statistics

# Konfiguration
TARGET_URL = "https://patrick-kaserer.de/"
USER_ID = "testuser@example.com"
ATTEMPTS = 50  # Anzahl der Test-Requests

def test_brute_force_protection():
    latencies = []
    status_codes = {}

    print(f"Starte Test auf {TARGET_URL} mit {ATTEMPTS} Versuchen...\n")

    for i in range(1, ATTEMPTS + 1):
        payload = {
            "username": USER_ID,
            "password": f"falsches_passwort_{i}"
        }

        start_time = time.perf_counter()
        try:
            response = requests.post(TARGET_URL, json=payload, timeout=5)
            end_time = time.perf_counter()
            
            latency = end_time - start_time
            latencies.append(latency)
            
            status = response.status_code
            status_codes[status] = status_codes.get(status, 0) + 1

            print(f"Request {i:02d}: Status {status} | Latenz: {latency:.4f}s")

            # Ein kurzes Delay, um den Test nicht wie einen DoS wirken zu lassen
            # Falls du echtes Rate-Limiting testen willst, setze dies auf 0
            time.sleep(0)

        except requests.exceptions.RequestException as e:
            print(f"Request {i:02d}: Fehler - {e}")

    # Auswertung
    print("\n--- Analyse ---")
    print(f"Status-Codes: {status_codes}")
    if latencies:
        print(f"Durchschnittliche Latenz: {statistics.mean(latencies):.4f}s")
        print(f"Standardabweichung: {statistics.stdev(latencies):.4f}s")

    # Interpretation
    if 429 in status_codes:
        print("\n[ERGEBNIS] Rate-Limiting aktiv (HTTP 429 erkannt).")
    elif any(l > statistics.mean(latencies[:3]) * 2 for l in latencies[-5:]):
        print("\n[ERGEBNIS] Tarpitting vermutet: Die Latenz steigt signifikant an.")
    else:
        print("\n[WARNUNG] Kein offensichtlicher Schutz erkannt. Alle Requests wurden gleich verarbeitet.")

if __name__ == "__main__":
    test_brute_force_protection()