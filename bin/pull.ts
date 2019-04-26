#!/usr/bin/env deno --allow-run

import {
  pull,
  cd,
  remove,
  backup,
  get,
  include
} from `./util.ts`

(async () => { // ------------------------------------------

  // peace out early if no args
  const args = [...Deno.args].slice(1)
  if (args.length === 0) {
    console.log(`\"Not using nothin\" - Townes Van Zandt`)
    return
  }

  // main function calling commands
  const main = async () => {
    let site = ''
    for (let i = 0; i < args.length; i++) {
      if (args[i] === '-s') {
        site = args[++i]
      }
    }

    const REMOVE = await remove()
    const { code } = await REMOVE.status()

    if (code === 0) {
      const rawOutput = await REMOVE.output()
      console.log(rawOutput, `fuckin a`)
    } else {
      const rawError = await REMOVE.stderrOutput()
      const errorString = new TextDecoder().decode(rawError)
      console.log(errorString, `fuckin a`)
    }

    Deno.exit(code)
  }
  main()

})() //-----------------------------------------------------
