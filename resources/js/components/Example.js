import React from "react";
import ReactDOM from "react-dom";
import { useEffect, useState } from "react";

function Example() {
    const [temp, setTemp] = useState("");
    const [word, setWord] = useState("");
    const [size, setSize] = useState(400);
    const [bgColor, setBgColor] = useState("ffffff");
    const [qrCode, setQrCode] = useState("");
    useEffect(() => {
        setQrCode(
            `http://api.qrserver.com/v1/create-qr-code/?data=${word}!&size=${size}x${size}&bgcolor=${bgColor}`
        );
    }, [word, size, bgColor]);

    function handleClick() {
        setWord(temp);
    }

    return (
        <div className="App">
            <h1>QR Code Generator</h1>
            <div className="input-box">
                <div className="gen">
                    <input
                        type="text"
                        onChange={e => {
                            setTemp(e.target.value);
                        }}
                        placeholder="Enter text to encode"
                    />
                    <button className="button" onClick={handleClick}>
                        Generate
                    </button>
                </div>
                <div className="extra">
                    <h5>Background Color:</h5>
                    <input
                        type="color"
                        onChange={e => {
                            setBgColor(e.target.value.substring(1));
                        }}
                    />
                    <h5>Dimension:</h5>
                    <input
                        type="range"
                        min="200"
                        max="600"
                        value={size}
                        onChange={e => {
                            setSize(e.target.value);
                        }}
                    />
                </div>
            </div>
            <div className="output-box">
                <img src={qrCode} alt="" />
                <a href={qrCode} download="QRCode">
                    <button type="button">Download</button>
                </a>
            </div>
        </div>
    );
}

export default Example;

if (document.getElementById("app-aq")) {
    ReactDOM.render(<Example />, document.getElementById("app-aq"));
}

// style this
// .App {
//     display: flex;
//     flex-direction: column;
//     justify-content: center;
//     align-items: center;
//     gap: 50px;
//     padding-top: 30px;
// }

// h1 {
//     font-size: 50px;
// }

// .gen input {
//     height: 35px;
//     width: 250px;
//     font-size: 20px;
//     padding-left: 5px;
// }

// button {
//     position: relative;
//     height: 38px;
//     width: 100px;
//     top: -2px;
//     font-size: 18px;
//     border: none;
//     color: whitesmoke;
//     background-color: forestgreen;
//     box-shadow: 2px 2px 5px rgb(74, 182, 74);
//     cursor: pointer;
// }

// button:active {
//     box-shadow: none;
// }

// .extra {
//     padding-top: 20px;
//     display: flex;
//     justify-content: space-around;
//     gap: 10px;
// }

// .output-box {
//     display: flex;
//     flex-direction: column;
//     align-items: center;
//     gap: 40px;
// }
