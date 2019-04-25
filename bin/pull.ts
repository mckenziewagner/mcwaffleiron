#!/usr/bin/env deno --allow-run

(async () => {
  // start

  const args = [...Deno.args].slice(1);

  const database = async (i) => {
    const arg = args[i];
    const nextArg = args[i++];
    return {
      removeInit: Deno.run({
        args: [
          'lando', 'ssh', '-c',
          'rm -f /app/database.sql.gz',
        ]
      }),
      backup: Deno.run({
        args: [
          'lando',
          'terminus',
          'backup:create',
          nextArg,
          '--element=db',
        ]
      }),
      getBackup: Deno.run({
        args: [
          'lando',
          'terminus',
          'backup:get',
          nextArg,
          '--element=db',
          '--to=/app/database.sql.gz',
        ]
      }),
      import:  Deno.run({
        args: [
          'lando', 'db-import',
          'database.sql.gz',
        ]
      }),
      removeOld: Deno.run({
        args: [
          'lando', 'ssh', '-c',
          'rm -f /app/database.sql.gz',
        ]
      }),
    }
  }

  let oldSite = '';
  let newSite = '';

  for (let i = 0; i < args.length; i++) {
    switch (arg) {
      // old site
      case '--oldSite' || '-o':
        const current = args[i];
        const next = args[i++];
        oldSite = next;
        break;

      // new site
      case '--site' || '-s':
        const current = args[i];
        const next = args[i++];
        newSite = next;
        break;

      // default
      case default:
        console.log('no input');
        break;
    }
  }

  console.log(oldSite, newSite);

  // end
})();
