"""One-off fix (already applied): replace the theme's default footer
template-part with a minimal custom footer. Kept for reference — running it
again is idempotent (it just re-applies the same content).

Requires WP_USER / WP_APP_PASSWORD, see .env.example.
"""

import json
import urllib.request
import urllib.error
import sys
import os

sys.path.insert(0, os.path.join(os.path.dirname(__file__), ".."))
from _wp_client import BASE, auth_header

NEW_FOOTER = (
    '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},'
    '"layout":{"type":"constrained"}} -->\n'
    '<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">\n'
    '<!-- wp:paragraph {"fontSize":"small","style":{"color":{"text":"#a7a7ab"}}} -->\n'
    '<p class="has-small-font-size" style="color:#a7a7ab">&copy; 2026 Auto Emotion</p>\n'
    '<!-- /wp:paragraph -->\n'
    '</div>\n'
    '<!-- /wp:group -->'
)

if __name__ == "__main__":
    payload = {"slug": "footer", "theme": "twentytwentyfive", "content": NEW_FOOTER}
    data = json.dumps(payload).encode("utf-8")
    req = urllib.request.Request(
        f"{BASE}/wp-json/wp/v2/template-parts",
        data=data,
        method="POST",
        headers={"Content-Type": "application/json; charset=utf-8", **auth_header()},
    )
    try:
        with urllib.request.urlopen(req) as resp:
            body = json.loads(resp.read().decode("utf-8"))
            print("STATUS", resp.status, "ID", body.get("id"))
    except urllib.error.HTTPError as e:
        print("HTTP ERROR", e.code)
        print(e.read().decode("utf-8"))
