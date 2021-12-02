// Login class
class Login extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
// Header class
class Header extends React.Component {
    // Render method
    render() {
        return (
            <header>
                <div id="logo">
                    <a href="../">Omninet</a>
                </div>
                <nav id="catalog">
                    <div>
                        <a href="../Shop">Shops</a>
                    </div>
                    <div>
                        <a href="../Brand">Brands</a>
                    </div>
                </nav>
                <nav id="utilities">
                    <div>
                        <a href="../User" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a href="../Search" class="fas fa-search faSearch"></a>
                    </div>
                    <div>
                        <a
                            href="../Cart"
                            class="fas fa-shopping-cart faCart"
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
            mailAddress: "",
            password: "",
            firstName: "",
            lastName: "",
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
        const delay = 2800;
        // Prevent default submission
        event.preventDefault();
        // Generating a POST request
        fetch("./Register.php", {
            method: "POST",
            body: JSON.stringify({
                mailAddress: this.state.mailAddress,
                password: this.state.password,
                firstName: this.state.firstName,
                lastName: this.state.lastName,
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
                        <div id="label">Register Form</div>
                        <input
                            type="email"
                            name="mailAddress"
                            placeholder="Mail Address"
                            value={this.state.mailAddress}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                        <input
                            type="password"
                            name="password"
                            placeholder="Password"
                            value={this.state.password}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                        <input
                            type="text"
                            name="firstName"
                            placeholder="First Name"
                            value={this.state.firstName}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                        <input
                            type="text"
                            name="lastName"
                            placeholder="Last Name"
                            value={this.state.lastName}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                        <div id="registerButton">
                            <button>Register</button>
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
ReactDOM.render(<Login />, document.getElementById("app"));
