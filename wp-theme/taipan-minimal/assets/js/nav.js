// Mobile header: the menu button opens the links below the bar; a link click,
// Escape or a click outside closes them again.
const nav = document.querySelector('.site-nav')
const toggle = nav?.querySelector('.nav-toggle')

function setOpen(open) {
  nav.classList.toggle('is-open', open)
  toggle.setAttribute('aria-expanded', String(open))
}

if (toggle) {
  toggle.addEventListener('click', () => setOpen(!nav.classList.contains('is-open')))
  nav.querySelectorAll('.site-nav-menu a').forEach((a) => a.addEventListener('click', () => setOpen(false)))
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && nav.classList.contains('is-open')) {
      setOpen(false)
      toggle.focus()
    }
  })
  document.addEventListener('click', (e) => {
    if (!nav.contains(e.target)) setOpen(false)
  })
}
