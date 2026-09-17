"""Shared WordPress REST API credentials loader.

Reads WP_BASE_URL / WP_USER / WP_APP_PASSWORD from the environment, falling
back to a local, gitignored `.env` file (see `.env.example` in the repo
root). No secrets live in source files — set them via `.env` or your shell.
"""

import base64
import os
import sys


def _load_dotenv(path=".env"):
    if not os.path.exists(path):
        return
    with open(path, encoding="utf-8") as f:
        for line in f:
            line = line.strip()
            if not line or line.startswith("#") or "=" not in line:
                continue
            key, value = line.split("=", 1)
            os.environ.setdefault(key.strip(), value.strip())


_load_dotenv(os.path.join(os.path.dirname(__file__), "..", ".env"))

BASE = os.environ.get("WP_BASE_URL", "https://autoemotion.stefanogranata.de")
USER = os.environ.get("WP_USER")
APPPW = os.environ.get("WP_APP_PASSWORD")

if not USER or not APPPW:
    sys.exit(
        "Missing WordPress credentials.\n"
        "Copy .env.example to .env and fill in WP_USER / WP_APP_PASSWORD\n"
        "(a WordPress Application Password, not the account password)."
    )


def auth_header():
    creds = base64.b64encode(f"{USER}:{APPPW}".encode("utf-8")).decode("ascii")
    return {"Authorization": f"Basic {creds}"}
