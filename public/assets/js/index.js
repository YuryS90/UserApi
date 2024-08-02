import './menu'
import './validate'
import './mult'
import '../css/dropzone.min.css'

// Информация загрузки файла
if (document.getElementById('fileInfo')) {
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const fileInfo = document.getElementById('fileInfo');
        fileInfo.innerHTML = ''; // Очищаем предыдущую информацию
        const files = event.target.files;

        if (files.length > 0) {
            const file = files[0];
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(2); // размер в килобайтах

            fileInfo.innerHTML = `
                    <strong>Название файла:</strong> ${fileName}<br>
                    <strong>Размер файла:</strong> ${fileSize} KB<br>
                `;
        }
    });
}
