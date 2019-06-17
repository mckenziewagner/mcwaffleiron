import { h } from `hyperapp`

const Slide = (props, children) =>
  h(
    `div`,
    {
      class: `item ${props.class}`,
      ...props
    },
    [
      h(
        `div`,
        {
          class: `flex flex-col container-sm`
        },
        children
      ),
    ]
  )

export default Slide
