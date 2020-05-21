require('dotenv').config()

const fs = require('fs')
const path = require('path')
const escapeStringRegexp = require('escape-string-regexp')

const { VERSION } = process.env
const TO_REMOVE = [
  'entry.html',
  'dev-entry'
]

try {
  const outputDir = path.resolve('package.json', '..', 'assets/dist')
  const outputFiles = fs.readdirSync(outputDir)

  outputFiles.forEach(fileName => {
    const fileWithPath = `${outputDir}/${fileName}`

    if(TO_REMOVE.some(nameToRemove => fileName.includes(nameToRemove))) {
      return fs.unlinkSync(fileWithPath)
    }

    // Replace hashes within CSS file paths
    if(/css$/.test(fileName)) {
      let contents = fs.readFileSync(fileWithPath, 'utf8')

      outputFiles.forEach(maybeHashedFile => {
        const pattern = new RegExp(`/${escapeStringRegexp(maybeHashedFile)}`, 'g')
        const withVersionNumberAndPath = `./${maybeHashedFile.replace(/\.\w+\.(\w+)$/, (_, ext) =>`.${VERSION}.${ext}`)}`
        contents = contents.replace(pattern, withVersionNumberAndPath)
      })
      fs.writeFileSync(fileWithPath, contents)
    }

    // Delete module splitting code in JS paths. Remove this when we need module splitting.
    if(/js$/.test(fileName)) {
      let contents = fs.readFileSync(fileWithPath, 'utf8')
      contents = contents.replace(/parcelRequire.*\n(.*)\n.*/, (_, js) => js)
      fs.writeFileSync(fileWithPath, contents)
    }

    // Insert hashes into filenames
    const withVersionNumber = fileName
      .replace(/\.\w+\.(\w+)$/, (_, ext) => `.${VERSION}.${ext}`) // Replace Parcel-generated hashes with version

    return fs.renameSync(fileWithPath, `${outputDir}/${withVersionNumber}`)
  })

  process.exit(0)
} catch(err) {
  console.log(err)
}