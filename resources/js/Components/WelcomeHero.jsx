import styles from "../../css/welcomeHero.css";
export default function WelcomeHero() {
    return (
        <div className="hero">
            <div className="heroContent">
                <div className="heroEyeBrow">WELCOME TO UNI</div>
                <div className="heroHeader">
                    Experience Social Media at its’ Maximum
                </div>
                <div className="heroSearchContainer">
                    <img className="searchImg" src={"search.svg"} />
                    <input />
                    <button
                        style={{
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-around",
                        }}
                    >
                        <img src="zipcode.svg" />
                        <div>80216</div>
                    </button>
                </div>
            </div>
            <div className="heroImgContainer">
                <img className="heroImg" src="heroImg.png" />
                <span className="heroImgBackground" />
            </div>
        </div>
    );
}
