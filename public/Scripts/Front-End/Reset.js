// Reset class
class Reset extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
// Header class
class Header extends React.Component {
    // Constructor method
    constructor(props) {
        super(props);
        this.state = {
            domain: "http://stormysystem.ddns.net/Omninet",
        };
    }
    // Render method
    render() {
        return (
            <header>
                <div id="logo">
                    <a href={this.state.domain}>Omninet</a>
                </div>
                <nav>
                    <div>
                        <a
                            href={this.state.domain + "/Shop"}
                            class="fas fa-shopping-cart faCart"
                        ></a>
                    </div>
                    <div>
                        <a
                            href={this.state.domain + "/User"}
                            class="fas fa-user faUser"
                        ></a>
                    </div>
                </nav>
            </header>
        );
    }
}
// Main class
class Main extends React.Component {
    // Constructor method
    constructor(props) {
        super(props);
        this.state = {
            // Input
            mailAddress: "",
            // Output
            success: "",
            message: "",
            url: "",
        };
    }
    // change handler method
    handleChange(event) {
        // Local variables
        const target = event.target;
        const value = target.value;
        const name = target.name;
        // Setting the value
        this.setState({
            [name]: value,
        });
    }
    // Submit handler method
    handleSubmit(event) {
        // Local variables
        const delay = 2533;
        // Prevent default submission
        event.preventDefault();
        // Generating a POST request
        fetch("./Login.php", {
            method: "POST",
            body: JSON.stringify({
                mailAddress: this.state.mailAddress,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) =>
                this.setState({
                    success: data.success,
                    message: data.message,
                    url: data.url,
                })
            )
            .then(() => this.redirector(delay));
    }
    // Redirector method
    redirector(delay) {
        setTimeout(() => {
            window.location.href = this.state.url;
        }, delay);
    }
    // Render method
    render() {
        return (
            <main>
                <div id="formContainer">
                    <form method="POST" onSubmit={this.handleSubmit.bind(this)}>
                        <div id="label">Reset Password Form</div>
                        <input
                            type="email"
                            name="mailAddress"
                            placeholder="Mail Address"
                            value={this.state.mailAddress}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                        <div id="resetButton">
                            <button>Reset</button>
                        </div>
                    </form>
                </div>
                <div id="serverRendering">
                    <h1 id={this.state.success}>{this.state.message}</h1>
                </div>
            </main>
        );
    }
}
// Footer class
class Footer extends React.Component {
    // Render method
    render() {
        return <footer>Omninet</footer>;
    }
}
// Rendering the page
ReactDOM.render(<Reset />, document.getElementById("app"));
