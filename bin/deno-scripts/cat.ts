#!/usr/bin/env deno --allow-read

(async () => {
  for (let i = 1; i < Deno.args.length; i++) {
    let filename = Deno.args[i];
    let file = await Deno.open(filename);
    await Deno.copy(Deno.stdout, file);
    file.close();
  }
})();
