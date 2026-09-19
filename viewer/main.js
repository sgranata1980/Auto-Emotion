const gallery = document.getElementById("gallery");

const files = await fetch("/manifest.json").then((res) => res.json());

for (const file of files) {
  const img = document.createElement("img");
  img.src = `/references/${encodeURIComponent(file)}`;
  img.alt = file;
  gallery.appendChild(img);
}
