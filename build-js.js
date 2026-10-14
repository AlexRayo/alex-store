const esbuild = require('esbuild');
const fs = require('fs');
const path = require('path');

const isWatch = process.argv.includes('--watch');

const outdir = path.join(__dirname, 'dist', 'js');
if (!fs.existsSync(outdir)) {
  fs.mkdirSync(outdir, { recursive: true });
}

const buildOptions = {
  entryPoints: [path.join(__dirname, 'src', 'js', 'main.js')],
  bundle: true,
  minify: !isWatch,
  sourcemap: isWatch,
  target: ['es2020'],
  outfile: path.join(outdir, 'main.bundle.js'),
};

async function run() {
  if (isWatch) {
    const ctx = await esbuild.context(buildOptions);
    await ctx.watch();
    console.log('Watching JavaScript changes...');
  } else {
    await esbuild.build(buildOptions);
    console.log('JavaScript built successfully into dist/js/main.bundle.js');
  }
}

run().catch(err => {
  console.error(err);
  process.exit(1);
});
