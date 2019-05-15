import { h } from `hyperapp`
import { tns } from 'tiny-slider/src/tiny-slider'
import picostyle from `picostyle`
const style = picostyle(h)

const Controls = style(`div`)({
  width: `100%`,
  position: `fixed`,
  top: `45vh`,
})

const Carousel = (props, children) => {
  if (!children) return h('div', {}, `no children`)
  let carousel = undefined
  return h(`section`, {
    id: 'h-carousel',
    class: `w-full h-full ${props.className}`,
    oncreate: () => {
      carousel = tns({
        container: document.querySelector(`#h-carousel .carousel-wrapper`),
        startIndex: props.pos,
        loop: true,
        items: 1,
        nav: false,
        autoHeight: true,
        arrowKeys: true,
        touch: true,
        mouseDrag: true,
        controlsContainer: document.querySelector(`#h-carousel .carousel-nav`),
        controlsText: ['', ''],
      })
      props.setCarousel(carousel)
    },
    ondestroy: () => {
      carousel.destroy()
    },
    ...props,
  }, [
    h(`div`, {
      class: `carousel-wrapper w-full`,
    }, [...children]),

    Controls(
      {
        class: `carousel-nav`
      },
      [
        h(`button`, {class: 'next'}, [
          h(`svg`, {
            class: `fill-white`,
            viewBox: `0 0 27 44`,
          }, h(`path`, {d: `M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z`}))
        ]),

        h(`button`, {class: 'prev'}, [
          h(`svg`, {
            class: `fill-white`,
            viewBox: `0 0 27 44`,
          }, h(`path`, {d: `M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z`}))
        ]),
      ]
    ),
  ])
}

export default Carousel
