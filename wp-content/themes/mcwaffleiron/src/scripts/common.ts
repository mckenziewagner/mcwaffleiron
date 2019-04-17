import { filterObj, parseNested, _fetch } from './util.ts'
import { tns } from 'tiny-slider/src/tiny-slider'
import config from '../../waffles.config.js'
import { View, state, actions, Container } from './app/index.ts'
import { app, h } from 'hyperapp'
import { withLogger } from "@hyperapp/logger"

const fetch = require('isomorphic-fetch')
const base = `/wp-json/wp/v2`

//
// no top level links in nav
const menuWithChildren = document.querySelector('.menu-item-has-children > a')
menuWithChildren.addEventListener('click', e => {
  e.preventDefault()
})

//
// open the menu
const openMobileMenu = document.querySelector('.open-mobile-menu')
const mobileMenu = document.querySelector('.mobile-menu')
openMobileMenu.addEventListener('click', (e => {
  e.preventDefault()
  openMobileMenu.toggleClass('is-active')
  mobileMenu.toggleClass('visible', 'invisible')
  mobileMenu.toggleClass('opacity-100', 'opacity-0')
}))

//
// toggle the modal
const modalToggles = Array.from(document.querySelectorAll('.modal-toggle'))
if (modalToggles) {
  const modal = document.querySelector('.modal')
  const body = document.body
  const html = document.querySelector("html")
  const toggleModal = () => {
    modal.toggleClass('invisible', 'visible')
    body.classList.toggle('modal-open')
    html.classList.toggle('modal-open')
  }
  window.toggleModal = toggleModal
  document.onkeydown = e => {
    if(e.key === "Escape" && body.classList.contains('modal-open')) {
      toggleModal()
    }
  }
  modalToggles.map(toggle => {
    toggle.addEventListener(`click`, e => {
      e.preventDefault()
      toggleModal()
    })
  })
}

//
// carousel logic for blade components
if (document.querySelectorAll('.carousel').length) {
  const carouselsEl = Array.from(document.querySelectorAll('.carousel'))
  const carousels = carouselsEl.map((carousel, i) => {
    const id = carousel.id
    const dataset = <HTMLElement>carousel.dataset
    const data = filterObj({...dataset})
    //console.log(data)
    return tns({
      ...data,
      container: document.querySelector(`#${id} .carousel-wrapper`),
      arrowKeys: true,
      touch: true,
      mouseDrag: true,
      controlsContainer: `#${id} .carousel-nav`,
      controlsText: ['', ''],
    })
  })
}

//
// fetchs data and open modal and sets it to the hyperapp
if (document.body.classList.contains(`archive`)) {
  if (document.querySelector('.menu-links') !== null) {
    const initHA = async () => {
      const dataset = {...document.querySelector('.menu-links').dataset}
      const all = await _fetch(`/sample-menu`, { per_page: 99 })
      const filtered = all.filter(e => e.acf.event_type.term_id == dataset.eventType)
      const sorted = filtered.sort((a, b) => a.title.rendered > b.title.rendered)
      const newState = {
        ...state,
        data: sorted,
      }
      const appI = app(newState, actions, View, document.getElementById('hyperapp'))
    }
    initHA()
  }
}


//const sent = true
if (document.querySelector('.legend') !== null) {
  window.addEventListener("scroll", function() {
    const elementTarget = document.querySelector('.legend')
    const footerNav = document.getElementById('footer-nav')
    if (window.scrollY < (elementTarget.offsetTop + elementTarget.offsetHeight)) {
      footerNav.classList.add('opacity-0')
      footerNav.classList.add('invisible')
    } else {
      footerNav.classList.remove('opacity-0')
      footerNav.classList.remove('invisible')
    }
  })
}

const footerNav = document.getElementById('footer-nav')
if (footerNav !== null) {
  footerNav.addEventListener('click', e => {
    const id = e.target.id
    console.log(id)
    if (id === 'print') {
      e.preventDefault()
      window.print()
    }
  })
}
