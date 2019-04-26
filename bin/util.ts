//
// deno run commands for scripting prolly not the
// best idea but im learning deno sooo

// all dem commands @TODO files (uploads)
export const cd = async path => await Deno.run({ args: [`cd`, path], stdout: `piped`, stderr: `piped` })
export const remove = async (backupName?: string) => await Deno.run({ args: [`lando`, `ssh`, `-c`, `rm -f /app/${backupName}`], stdout: `piped`, stderr: `piped` })
export const backup = async siteEnv => await Deno.run({ args: [`lando`, `terminus`, `backup:create`, siteEnv, `--element=db`], stdout: `piped`, stderr: `piped` })
export const get = async siteEnv => await Deno.run({ args: [`lando`, `terminus`, `backup:get`, siteEnv, `--element=db`, `--to=/app/database.sql.gz`], stdout: `piped`, stderr: `piped` })
export const include = async (backupName?: string) => await Deno.run({ args: [`lando`, `db-import`, backupName], stdout: `piped`, stderr: `piped` })

// pull in pantheon site from upstream and use
// upstreams default db and files
export const pull = async ({
  siteEnv = `mcwaffleiron.dev`,
  path = `../`,
  backupName = `database.sql.gz`
}) => {
  const _cd = await cd(path)
  const _removeInit = await remove(backupName)
  const _backup = await backup(siteEnv)
  const _get = await get(siteEnv)
  const _include = await include(backupName)
  const _removeEnd = await remove(backupName)

  return {
    _cd,
    _removeInit,
    _backup,
    _get,
    _include,
    _removeEnd,
  }
}
