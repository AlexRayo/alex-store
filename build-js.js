const esbuild = require('esbuild');
const fs = require('fs');
const path = require('path');

const isWatch = process.argv.includes('--watch');

function walkAndReplace(dir) {
  const files = fs.readdirSync(dir);
  for (const file of files) {
    if (file === 'node_modules' || file === '.git' || file === 'dist') continue;
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      walkAndReplace(filePath);
    } else if (file.endsWith('.php')) {
      let str = fs.readFileSync(filePath, 'utf8');
      const original = str;
      str = str.split("'tech-store'").join("'alex-store'");
      str = str.split('"tech-store"').join('"alex-store"');
      str = str.split('tech_store_').join('alex_store_');
      if (str !== original) {
        fs.writeFileSync(filePath, str, 'utf8');
      }
    }
  }
}
walkAndReplace(__dirname);

const buildOptions = {
  entryPoints: [path.join(__dirname, 'src', 'js', 'main.js')],
  bundle: true,
  minify: !isWatch,
  sourcemap: isWatch,
  target: ['es2020'],
  outfile: path.join(outdir, 'main.bundle.js'),
};

if (isWatch) {
  esbuild.context(buildOptions).then(ctx => {
    ctx.watch();
    console.log('Watching JavaScript changes...');
  }).catch(err => {
    console.error(err);
    process.exit(1);
  });
} else {
  esbuild.build(buildOptions).then(() => {
    console.log('JavaScript built successfully into dist/js/main.bundle.js');
  }).catch(err => {
    console.error(err);
    process.exit(1);
  });
}
