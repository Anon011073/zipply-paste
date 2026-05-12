from playwright.sync_api import sync_playwright

def run(page):
    try:
        page.goto("http://localhost:8000/")
        page.wait_for_timeout(1000)
        page.screenshot(path="screenshot.png")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        run(page)
        browser.close()
