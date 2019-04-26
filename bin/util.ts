//
// deno run commands for scripting prolly not the best idea but im learning deno sooo

export const cd = async path => await Deno.run({ args: ['cd', '../'] })
export const removeOldDb = async backupName => await Deno.run({ args: ['lando', 'ssh', '-c', `rm -f /app/${backupName}`] })
export const backupDb = async siteEnv => await Deno.run({ args: ['lando', 'terminus', 'backup:create', siteEnv, '--element=db'] })
export const getDb = async siteEnv => await Deno.run({ args: ['lando', 'terminus', 'backup:get', siteEnv, '--element=db', '--to=/app/database.sql.gz'] })
export const importDb = async () => await Deno.run({ args: ['lando', 'db-import', 'database.sql.gz'] })

// pull in database and @TODO files (uploads)
export const pull = async ({
  siteEnv = `mcwaffleiron.dev`,
  path = `../`,
  backupName = `database.sql.gz`
}) => {
  const _cd = await cd(path)
  const _removeOldDb = await removeOldDb(backupName)
  const _backupDb = await backupDb(siteEnv)
  const _getDb = await getDb(siteEnv)
  const _importDb = await getDb(siteEnv)
  const _removeOldDbAgain = await removeOldDb(backupName)
  return {
    _cd,
    _removeOldDb,
    _backupDb,
    _getDb,
    _importDb,
    _removeOldDbAgain,
  }
}
