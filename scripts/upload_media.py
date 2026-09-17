"""Upload a local image file to the WordPress Media Library.

Usage:
    python3 scripts/upload_media.py <local_path> <target_filename>

Requires WP_USER / WP_APP_PASSWORD, see .env.example.
"""

import sys
import requests

from _wp_client import BASE, USER, APPPW


def upload(path, filename):
    with open(path, "rb") as f:
        data = f.read()

    content_type = "image/jpeg" if filename.lower().endswith((".jpg", ".jpeg")) else "image/png"

    r = requests.post(
        f"{BASE}/wp-json/wp/v2/media",
        auth=(USER, APPPW),
        headers={
            "Content-Type": content_type,
            "Content-Disposition": f'attachment; filename="{filename}"',
        },
        data=data,
    )
    print("STATUS", r.status_code)
    j = r.json()
    print("ID", j.get("id"))
    print("SOURCE URL", j.get("source_url"))
    print("MEDIA DETAILS SIZES", list(j.get("media_details", {}).get("sizes", {}).keys()))


if __name__ == "__main__":
    upload(sys.argv[1], sys.argv[2])
