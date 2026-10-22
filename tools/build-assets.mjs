import { build, transform } from 'esbuild';
import { readFile, writeFile, mkdir, watch } from 'node:fs/promises';
import { createHash } from 'node:crypto';
import path from 'node:path';

const production = process.argv.includes('--production');
const styles = {
    'resources/css/app.css': 'css/app.css',
    'node_modules/bootstrap/dist/css/bootstrap.min.css': 'css/bootstrap.min.css',
    'resources/vendor/icofont/icofont.min.css': 'css/icofont.min.css',
    'resources/vendor/boxicons/css/boxicons.min.css': 'css/boxicons.min.css',
    'resources/vendor/venobox/venobox.css': 'css/venobox.css',
    'resources/vendor/owl.carousel/assets/owl.carousel.min.css': 'css/owl.carousel.min.css',
    'resources/vendor/aos/aos.css': 'css/aos.css',
    'resources/css/style.css': 'css/style.css',
    'resources/css/dashboard.css': 'css/dashboard.css',
    'resources/css/login.css': 'css/login.css',
    'node_modules/bootstrap/dist/css/bootstrap.css': 'css/css/bootstrap2.min.css',
};
const scripts = {
    'js/dashboard.js': ['resources/js/dashboard.js'],
    'js/js.js': [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'resources/vendor/jquery.easing/jquery.easing.min.js',
        'resources/vendor/php-email-form/validate.js',
        'resources/vendor/jquery-sticky/jquery.sticky.js',
        'resources/vendor/venobox/venobox.min.js',
        'resources/vendor/owl.carousel/owl.carousel.min.js',
        'resources/vendor/isotope-layout/isotope.pkgd.min.js',
        'resources/vendor/aos/aos.js',
        'resources/js/main.js',
    ],
    'js/bootstrap.bundle.min.js': ['node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'],
};

async function compile() {
    const manifest = {};
    function record(file, content) {
        const url = '/' + path.relative(path.resolve('public'), file).split(path.sep).join('/');
        const hash = createHash('sha256').update(content).digest('hex').slice(0, 20);
        manifest[url] = production ? `${url}?id=${hash}` : url;
    }
    for (const [source, destination] of Object.entries(styles)) {
        const result = await build({
            entryPoints: [source], outfile: `public/${destination}`, bundle: true,
            minify: production, write: false, publicPath: '/css/',
            assetNames: 'assets/[name]-[hash]', external: ['/img/*'],
            loader: Object.fromEntries(['.woff', '.woff2', '.ttf', '.eot', '.svg', '.png', '.jpg', '.gif'].map(ext => [ext, 'file'])),
        });
        for (const file of result.outputFiles) {
            await mkdir(path.dirname(file.path), { recursive: true });
            await writeFile(file.path, file.contents);
            record(file.path, file.contents);
        }
    }
    for (const [destination, sources] of Object.entries(scripts)) {
        // Preserve the shared browser globals and execution order of legacy plugins.
        const source = (await Promise.all(sources.map(file => readFile(file, 'utf8')))).join('\n;\n');
        const result = await transform(source, { loader: 'js', minify: production, target: 'es2018', legalComments: 'inline' });
        const file = path.resolve('public', destination);
        await mkdir(path.dirname(file), { recursive: true });
        await writeFile(file, result.code);
        record(file, result.code);
    }
    await writeFile('public/mix-manifest.json', JSON.stringify(manifest, null, 4) + '\n');
    console.log(`Built ${Object.keys(styles).length} stylesheets and ${Object.keys(scripts).length} scripts.`);
}

await compile();
if (process.argv.includes('--watch')) {
    // Rebuild sequentially; no development HTTP server is exposed.
    for await (const event of watch('resources', { recursive: true })) {
        try { await compile(); } catch (error) { console.error(error); }
    }
}
