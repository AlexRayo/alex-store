const fs = require('fs');
const path = require('path');

const targetDir = __dirname;
console.log('Target directory is:', targetDir);

let count = 0;

function walk(dir) {
  const files = fs.readdirSync(dir);
  for (const file of files) {
    if (file === 'node_modules' || file === '.git' || file === 'dist' || file === 'replace-all.js') continue;
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      walk(filePath);
    } else if (file.endsWith('.php')) {
      let str = fs.readFileSync(filePath, 'utf8');
      const original = str;
      str = str.split("'tech-store'").join("'alex-store'");
      str = str.split('"tech-store"').join('"alex-store"');
      str = str.split('tech_store_').join('alex_store_');
      if (str !== original) {
        fs.writeFileSync(filePath, str, 'utf8');
        count++;
        console.log('Modified:', path.relative(targetDir, filePath));
      }
    }
  }
}

walk(targetDir);
console.log(`Successfully modified ${count} files.`);
