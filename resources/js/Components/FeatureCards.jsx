// TODO: Export data into types we can use between cms and front end
// TODO: Begin work on user authentication so we can do the below
// TODO: Begin work on cms
export default function FeatureCards() {
    return (
        <div
            style={{
                padding: "100px 0 0 0",
                display: "flex",
                justifyContent: "space-between",
                flexWrap: "wrap",
            }}
        >
            <div
                style={{
                    width: "550px",
                    height: "550px",
                    backgroundColor: "#FFC83F",
                    borderRadius: "40px",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    flexDirection: "column",
                    textAlign: "center",
                }}
            >
                <img
                    style={{ width: "250px", height: "250px" }}
                    src="events.png"
                />
                <div style={{ fontSize: "50px" }}>Manage Events</div>
                <div>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis.
                </div>
            </div>
            <div
                style={{
                    width: "550px",
                    height: "550px",
                    backgroundColor: "#FF837B",
                    borderRadius: "40px",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    flexDirection: "column",
                    textAlign: "center",
                    color: "white",
                }}
            >
                <img
                    style={{ width: "250px", height: "250px" }}
                    src="friends.png"
                />
                <div style={{ fontSize: "50px" }}>Find Friends</div>
                <div>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis.
                </div>
            </div>
            <div
                style={{
                    padding: "50px 0 0 0",
                    display: "flex",
                    justifyContent: "space-between",
                    width: "100%",
                }}
            >
                <div
                    style={{
                        width: "550px",
                        height: "550px",
                        backgroundColor: "#FFC83F",
                        borderRadius: "40px",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        flexDirection: "column",
                        textAlign: "center",
                    }}
                >
                    <img src="events.png" />
                    <div style={{ fontSize: "50px" }}>Manage Events</div>
                    <div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis.
                    </div>
                </div>
                <div
                    style={{
                        width: "550px",
                        height: "550px",
                        backgroundColor: "#FFC83F",
                        borderRadius: "40px",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        flexDirection: "column",
                        textAlign: "center",
                    }}
                >
                    <img src="events.png" />
                    <div style={{ fontSize: "50px" }}>Manage Events</div>
                    <div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis.
                    </div>
                </div>
            </div>
        </div>
    );
}
