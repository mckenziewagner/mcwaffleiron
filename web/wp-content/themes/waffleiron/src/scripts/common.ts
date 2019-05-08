import { filterObj, _fetch } from './util'
import { tns } from 'tiny-slider'
import { View, state, actions } from './app/index'
import { app } from 'hyperapp'
//import { withLogger } from "@hyperapp/logger"
//import config from '../../waffles.config.js'

//const fetch = require('isomorphic-fetch')
//const base = `/wp-json/wp/v2`

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
  //window.toggleModal = toggleModal
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
  const carouselsEl: HTMLElement[] = Array.from(document.querySelectorAll('.carousel'))
  carouselsEl.map((carousel) => {
    const id = carousel.id
    const { dataset } = carousel
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
      const { dataset } = document.querySelector('.menu-links') as HTMLElement
      const allData = await _fetch(`/sample-menu`, { per_page: 99 })
      const filtered: object[] = allData.filter((e: any) => e.acf.event_type.term_id == dataset.eventType)
      const sorted: object[] = filtered.sort((a: any, b: any):any => a.title.rendered > b.title.rendered)
      const newState = {
        ...state,
        data: sorted,
      }
      app(newState, actions, View, document.getElementById('hyperapp'))
    }
    initHA()
  }
}


//const sent = true
if (document.querySelector('.legend') !== null) {
  window.addEventListener("scroll", function() {
    const elementTarget:HTMLElement = document.querySelector('.legend')
    const footerNav:HTMLElement = document.getElementById('footer-nav')
    if (window.scrollY < (elementTarget.offsetTop + elementTarget.offsetHeight)) {
      footerNav.classList.add('opacity-0')
      footerNav.classList.add('invisible')
    } else {
      footerNav.classList.remove('opacity-0')
      footerNav.classList.remove('invisible')
    }
  })
}

const footerNav:HTMLElement = document.getElementById('footer-nav')
if (footerNav !== null) {
  footerNav.addEventListener('click', (e:Event) => {
    const id = (e.target as Element).id
    if (id === 'print') {
      e.preventDefault()
      window.print()
    }
  })
}
