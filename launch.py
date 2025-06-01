import subprocess
import threading
import time

def run_npm():
    """Start npm run dev"""
    try:
        subprocess.run(["npm", "run", "dev"], check=True)
    except subprocess.CalledProcessError as e:
        print(f"npm run dev failed with error: {e}")

def run_artisan():
    """Start php artisan serve"""
    try:
        subprocess.run(["php", "artisan", "serve"], check=True)
    except subprocess.CalledProcessError as e:
        print(f"php artisan serve failed with error: {e}")

if __name__ == "__main__":
    # Start npm in a thread
    npm_thread = threading.Thread(target=run_npm)
    npm_thread.daemon = True  # Thread will exit when main program exits
    npm_thread.start()

    # Start artisan in main thread
    run_artisan()

    # Keep the script running
    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        print("Shutting down servers...")
