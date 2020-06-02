function initializeButtonHover() {
  const btns = document.querySelectorAll('.dpsp-networks-btns-wrapper li a')
  for(const btn of btns) {
    btn.addEventListener('mouseenter', ({ target }) => {
      target.parentNode.classList.add('dpsp-hover')
    })
    btn.addEventListener('mouseleave', ({ target }) => {
      target.parentNode.classList.remove('dpsp-hover')
    })
  }
}

function initializePinterest() {
  const btns = document.querySelectorAll('.dpsp-network-btn.dpsp-pinterest')
  Array.prototype.forEach.call(btns, (btn) => {
    btn.addEventListener('click', (e) => {
      const { target } = e

      if(!/#$/.test(target.href)) {
        e.stopPropagation()
        e.preventDefault()
        return
      }

      e.preventDefault()

      const el = document.createElement('script');
      el.setAttribute('type', 'text/javascript');
      el.setAttribute('charset', 'UTF-8');
      el.setAttribute('src', 'https://assets.pinterest.com/js/pinmarklet.js');
      document.body.appendChild(el);
    })
  })
}

function initializePrint() {
  const btns = document.querySelectorAll('.dpsp-network-btn.dpsp-print')
  Array.prototype.forEach.call(btns, (btn) => {
    btn.addEventListener('click', () => {
      window.print()
    })
  })
}

function initializeButtons() {
  const btns = document.querySelectorAll('.dpsp-network-btn')
  Array.prototype.forEach.call(btns, (btn) => {
    btn.addEventListener('click', (e) => {
      const { target } = e

      if(target.classList.contains('dpsp-email')) return

      e.preventDefault()

      if(/#$/.test(target.href)) {
        e.stopPropagation()
        return
      }

      target.blur()

      window.open(
        target.href,
        'targetWindow',
        `toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=700,height=300,top=200,left=${(window.innerWidth - 700)/2}`
      )

    })
  })
}

const init = () => {
  initializeButtonHover()
  initializePinterest()
  initializePrint()
  initializeButtons()
  window.removeEventListener('mousemove', init)
}

window.addEventListener('mousemove', init)