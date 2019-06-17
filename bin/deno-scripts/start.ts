#!/usr/bin/env deno --allow-read

import { logger } from './mod.ts'

(async () => {
  // get out because dum shit
  const args = [...Deno.args].slice(1) // 0 index is just command given
  if (!args.length) return logger()

  for (let i = 1; i < args.length; i++) {
    let arg = args[i]
    let file = await Deno.open(arg)
    await Deno.copy(Deno.stdout, file)
    file.close()
  }
})()
