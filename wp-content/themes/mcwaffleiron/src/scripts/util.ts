//
// global DOM extensions
declare global {
  interface Element {
    toggleClass(class1: string, class2?: string): void
  }
  interface Object {
    filter(predicate: (t: any) => boolean): object
  }
}

//
// toggleclass like jquery but without it
Element.prototype.toggleClass = function(class1, class2) {
  if (class2 === null || class2 === undefined) {
    return this.classList.toggle(class1)
  }
  if (this.classList.contains(class1)) {
    this.classList.remove(class1)
    this.classList.add(class2)
  } else {
    this.classList.remove(class2)
    this.classList.add(class1)
  }
  return
}

//
// filter an obj similar to array filtering
export const filterObj = (obj: object): object => {
  let newObj = {}
  Object.keys(obj).forEach((prop) => {
    if (obj[prop] && obj[prop] !== '') { newObj[prop] = obj[prop] }
    if ((obj[prop] && obj[prop] === 'true')) {
      newObj[prop] = true
    }
    if (obj[prop] && obj[prop] === 'false') {
      newObj[prop] = false
    }
    if (obj[prop] && (/^[\],:{}\s]*$/).test(obj[prop].replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
      newObj[prop] = JSON.parse(obj[prop])
    }
  })
  return newObj
};

export const parseNested = obj => {
  const newObj = {}
  for (let key in obj) {
    const val = obj[key]
    if (val && typeof val !== 'string') return val
    if (/^[\],:{}\s]*$/.test(val.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
      newObj[key] = JSON.parse(val)
    } else {
      newObj[key] = val
    }
  }
  return Object.keys(obj).forEach(prop => {
    if (typeof val !== 'string') return val
    if (/^[\],:{}\s]*$/.test(val.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
      JSON.parse(val)
    }
  })
}

const fetch = require('isomorphic-fetch')
const config = require('../../waffles.config.js')()
const base = `${config.siteUrl}/wp-json/wp/v2`
export const _fetch = async (path, params, fetchOpts) => {
  var url = new URL(`${base}${path}`)
  if (params != null) Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
  //console.log(url)
  return await fetch(url, fetchOpts || {method: `get`})
    .then(res => res.json())
    .catch(ex => console.log("Fetch Exception", ex));
};
