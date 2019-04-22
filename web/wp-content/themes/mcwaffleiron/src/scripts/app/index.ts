//
// kick in the hyperapp!!!!!!!!!!!!
import { h } from `hyperapp`
import Carousel from `./Carousel.ts`
import Slide from `./Slide.ts`
import picostyle from `picostyle`
const style = picostyle(h)

export const state = {
  data: undefined,
  carousel: undefined,
  pos: 0,
}

export const actions = {
  init: () => (state, actions) => {
    const menuLinks = document.querySelector('.menu-links')
    //console.log(menuLinks)
    menuLinks.addEventListener(`click`, function(e) {
      //console.log(this)
      const contains = target => (
        e.target.classList.contains(target)
      )
      //console.log(e.target)

      if (contains(`menu-link-target`) || contains(`title`) || contains(`sub-heading`)) {
        document.getElementById(`hyperapp`).scrollTo(0, 0)
        const menuLinkTarget = contains(`menu-link-target`) ? e.target : e.target.parentNode
        const dataset = {...menuLinkTarget.dataset}
        //console.log(dataset)
        const pos = dataset.index
        state.carousel.goTo(pos)
      }

    })
  },
  setCarousel: carousel => state => ({carousel}),
  setPos: pos => state => ({pos}),
  setData: data => state => ({data}),
}

export const Container = style(`section`)({
  top: `160px`,
  'margin-top': `20px`,
  display: `flex`,
  position: `relative`,
  'flex-direction': `column`,
  'justify-content': `center`,
  width: `100%`,
  height: `45vh`,
  '@media (max-width: 768px)': {
    top: `130px`,
  },
})

const divider = (props, children) =>
  h(
    `div`,
    {
      ...props,
      class: `border-b-8 border-green border-dotted w-1/4 mx-auto my-12 ${props.class}`,
    },
    children
  )

export const Divider = style(divider)({
  position: `relative`,
})

export const Testimonial = style(`div`)({
  position           : `relative`,
  width              : `100%`,
  padding            : `60px 30px 75px 80px`,
  'margin-top'       : `4rem`,
  'margin-left'      : `auto`,
  'max-width'        : `786px`,
  'background-color' : `#fdb927`,
  '@media (max-width: 768px)': {
    padding: `1rem`,
  }
})

export const View = (state, actions) =>
  Container({
    oncreate: actions.init,
  },
    h(
      Carousel,
      {
        className: 'my-48 h-full',
        pos: state.pos,
        setCarousel: actions.setCarousel,
      },
      state.data.map((item, i) => {
        //if (i === state.data.length - 1) return
        return h(
          Slide,
          {
            pos: i,
            key: i,
          },
          [
            h(
              `article`,
              {
                class: `bg-grey-light border-3 border-solid border-green pt-12 pb-24 mb-24`
              },
              [
                h(
                  `header`,
                  {class: `text-center md:px-24 px-4`},
                  [
                    h(
                      `h4`,
                      {
                        class: `text-white uppercase font-sans font-base tracking-wide`
                      },
                      item.acf.event_type.name
                    ),
                    h(
                      `h2`,
                      {class: `font-sans text-green font-thin text-4xl uppercase leading-tight tracking-wider`},
                      item.title.rendered
                    ),
                  ]
                ),
                h(
                  `section`,
                  {},
                  [
                    (item.acf.gallery.length) && h(
                      `figure`,
                      {class: `gallery w-full md:h-86 h-64 flex flex-row mt-10 mb-5 md:px-24 px-4`},
                      [
                        h(
                          `div`,
                          {class: `left-col ${item.acf.gallery.length > 1 ? 'w-3/5' : 'w-full'}`},
                          h(
                            `img`,
                            {
                              class: `w-full h-full fit-cover`,
                              src: item.acf.gallery[0].url
                            }
                          )
                        ),
                        (item.acf.gallery.length > 1) && h(
                          `div`,
                          {class: `right-col flex flex-col ${item.acf.gallery.length > 1 ? 'w-2/5' : ''}`},
                          ...item.acf.gallery.map((image, i) => (
                            (i !== 0) && h(
                              `img`,
                              {
                                class: `h-full fit-cover`,
                                src: image.url
                              }
                            )
                          ))
                        ),
                      ]
                    ),
                    !(item.acf.gallery.length) && Divider(),
                    h(
                      `div`,
                      {class: `meals md:px-48 px-4 pt-12`},
                      item.acf.meals.map((meal, i) => (
                        h(`h2`, {
                          class: `font-serif italic text-green text-lg leading-normal md:text-center text-left py-2`,
                        }, meal.post_title)
                      ))
                    ),
                  ]
                ),
                h(
                  `footer`,
                  {class: `w-full relative`},
                  [
                    Divider({class: `mb-36`}),

                    //
                    // testimonial
                    (item.acf.testimonial) && Testimonial(
                      {},
                      [
                        h(
                          `h2`,
                          {
                            class: `font-sans font-light md:text-left text-center md:-mt-3 md:-ml-10 tracking-wide md:absolute relative pin-t pin-l uppercase text-2xl text-green`,
                          },
                          `What they had to say...`
                        ),
                        style((props, children) => h(
                          `div`,
                          {class: `md:max-w-29r text-orange font-serif text-base italic leading-normal`},
                          item.acf.testimonial.text
                        ))({
                          width: `330px`,
                        }),
                        h(
                          `h3`,
                          {class: `font-sans uppercase roman mt-6 font-thin text-orange tracking-wide`},
                          `— ${item.acf.testimonial.client_name}`
                        ),
                      ]
                    ),
                    h(
                      `button`,
                      {
                        class: `modal-toggle uppercase text-green hover:text-white bg-transparent hover:bg-green font-sans border border-green md:px-16 px-6 py-2 font-thin tracking-wider text-center mt-24 flex flex-row items-center center mx-auto`,
                        innerHTML: `<span style="margin-top: -5px;" class="text-3xl leading-0 mr-1 font-mono">◂</span> Back`,
                        onclick: e => window & window.toggleModal(),
                      }
                    ),
                  ]
                )
              ]
            ),
          ]
        )
      })
    )
  )

//export const appI = app(state, actions, View, document.getElementById('hyperapp'))
