import express, { Express, Request, Response } from 'express';
import mongoose from 'mongoose';
import cors from 'cors';
import dotenv from 'dotenv';

dotenv.config();
const app: Express = express();
const port = process.env.PORT;

mongoose.connect('mongodb://localhost:27017/handheld', {});

const db = mongoose.connection;
db.on('error', (error) => console.log(error));
db.once('open', () => console.log('DB connected...'));

app.use(cors());
app.use(express.json());
app.use(cors());

app.get('/', (req: Request, res: Response) => {
    res.send('Express + TypeScript Server');
});

app.listen(port, () => {
    console.log(`[server]: Server is running at https://localhost:${port}`);
});
