import multer from 'multer';
import path from 'path';

const storage = multer.diskStorage({
    destination: (req, file, callback) => {
        callback(null, './images')
    },
    filename: (req, file, callback) => {
        const time = new Date.now()
        callback(null, `${time}_${path.extname(file.originalname)}`)
    }
})

const upload = multer({ storage }).single('file')

export default upload