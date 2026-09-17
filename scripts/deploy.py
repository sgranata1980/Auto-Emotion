"""Push a page source from site/ to a WordPress page via the REST API.

Usage:
    python3 scripts/deploy.py <file> <title> <slug> [status] [page_id]

Examples:
    python3 scripts/deploy.py site/cupra.html "Cupra bei Auto Emotion" cupra publish 2
    python3 scripts/deploy.py site/website-relaunch.html "Website & KI-Sichtbarkeit" website-relaunch publish

Requires WP_USER / WP_APP_PASSWORD, see .env.example.
"""

import sys
import json
import re
import urllib.request
import urllib.error

from _wp_client import BASE, auth_header

STRIP_PATTERNS = [
    r'^\s*<!DOCTYPE html>\s*$',
    r'^\s*<html[ >].*$|^\s*<html>\s*$',
    r'^\s*</html>\s*$',
    r'^\s*<head>\s*$',
    r'^\s*</head>\s*$',
    r'^\s*<body[ >].*$|^\s*<body>\s*$',
    r'^\s*</body>\s*$',
    r'^\s*<meta charset.*$',
    r'^\s*<title>.*</title>\s*$',
]
STRIP_RE = re.compile("|".join(STRIP_PATTERNS), re.IGNORECASE)


def push(file_path, title, slug, status="draft", page_id=None):
    with open(file_path, "r", encoding="utf-8") as f:
        html = f.read()

    # Drop the full-document wrapper tags (WP's own <html>/<head>/<body>
    # already wrap the page) so only the page-specific markup remains.
    body_lines = [line for line in html.split("\n") if not STRIP_RE.match(line)]
    content = "\n".join(body_lines)

    # Internal cross-doc link fix: local "index.html" back-link -> WP site root.
    content = content.replace('href="index.html"', 'href="/"')

    # Width is handled at the template level (page-no-title uses
    # layout:"default"), so the content doesn't need a vw-breakout wrapper.
    block_content = '<!-- wp:html {"align":"full"} -->\n' + content + "\n<!-- /wp:html -->"

    payload = {
        "title": title,
        "slug": slug,
        "status": status,
        "content": block_content,
        "template": "page-no-title",
    }
    data = json.dumps(payload).encode("utf-8")

    url = f"{BASE}/wp-json/wp/v2/pages"
    if page_id:
        url += f"/{page_id}"
    req = urllib.request.Request(
        url,
        data=data,
        method="POST",  # WP REST accepts POST for update too when an ID is in the URL
        headers={
            "Content-Type": "application/json; charset=utf-8",
            **auth_header(),
        },
    )
    try:
        with urllib.request.urlopen(req) as resp:
            body = json.loads(resp.read().decode("utf-8"))
            print("STATUS", resp.status)
            print("ID", body.get("id"), "LINK", body.get("link"))
    except urllib.error.HTTPError as e:
        print("HTTP ERROR", e.code)
        print(e.read().decode("utf-8"))


if __name__ == "__main__":
    file_path, title, slug = sys.argv[1], sys.argv[2], sys.argv[3]
    status = sys.argv[4] if len(sys.argv) > 4 else "draft"
    pid = sys.argv[5] if len(sys.argv) > 5 else None
    push(file_path, title, slug, status, pid)
