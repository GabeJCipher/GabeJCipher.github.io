const viewer = document.querySelector('.image-viewer');
const viewerImage = viewer.querySelector('img');
const viewerTitle = viewer.querySelector('#viewer-title');

viewer.addEventListener('click', (event) => {
  if (event.target === viewer) viewer.close();
});

for (const gallery of document.querySelectorAll('.gallery')) {
  const track = gallery.querySelector('.gallery-track');
  const links = [...track.querySelectorAll('.gallery-image')];
  const previous = gallery.querySelector('.gallery-previous');
  const next = gallery.querySelector('.gallery-next');
  const status = gallery.querySelector('.gallery-status');
  const count = gallery.querySelector('.gallery-count');
  const caption = gallery.querySelector('.gallery-caption');
  const project = document.getElementById(gallery.getAttribute('aria-labelledby'));
  let current = -1;

  function update(index) {
    if (index === current) return;

    current = index;
    count.textContent = `${index + 1} / ${links.length}`;
    caption.textContent = links[index].dataset.caption;
    links.forEach((link, position) => {
      link.tabIndex = position === index ? 0 : -1;
    });
  }

  function move(direction) {
    const index = (current + direction + links.length) % links.length;
    const imageHasFocus = links.includes(document.activeElement);
    track.scrollLeft = index * track.clientWidth;
    update(index);
    if (imageHasFocus) links[index].focus({ preventScroll: true });
  }

  track.addEventListener('scroll', () => {
    const index = Math.round(track.scrollLeft / track.clientWidth);
    update(Math.min(Math.max(index, 0), links.length - 1));
  }, { passive: true });

  previous.addEventListener('click', () => move(-1));
  next.addEventListener('click', () => move(1));
  gallery.addEventListener('keydown', (event) => {
    if (event.altKey || event.ctrlKey || event.metaKey || event.shiftKey) return;
    if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
    event.preventDefault();
    move(event.key === 'ArrowLeft' ? -1 : 1);
  });

  track.addEventListener('click', (event) => {
    const link = event.target.closest('.gallery-image');
    if (!link || !viewer.showModal || event.altKey || event.ctrlKey || event.metaKey || event.shiftKey) return;

    event.preventDefault();
    viewerTitle.textContent = `${project.textContent} · ${link.dataset.caption}`;
    viewerImage.src = link.href;
    viewerImage.alt = link.querySelector('img').alt;
    viewer.showModal();
  });

  update(0);
  for (const control of [previous, status, next]) control.hidden = false;
  gallery.dataset.ready = '';
}
