// Seller class
class Seller extends React.Component {
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
                    <a href="./">Omninet</a>
                </div>
                <nav>
                    <div>
                        <a href="./Profile" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a
                            href="./Logout"
                            class="fas fa-sign-out-alt faLogout"
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
            name: "",
            image: "",
            success: "",
            message: "",
            url: "",
        };
    }
    // Change handler method
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
        const delay = 1560;
        // Prevent default submission
        event.preventDefault();
        // Generating a POST request
        fetch("./Seller.php", {
            method: "POST",
            body: JSON.stringify({
                name: this.state.name,
                image: this.state.image,
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
                <form method="POST" enctype="multipart/form-data">
                    <div id="label">Adding items</div>
                    <input
                        type="text"
                        name="name"
                        placeholder="Name"
                        value={this.state.name}
                        onChange={this.handleChange.bind(this)}
                        required
                    />
                    <label class="fas fa-upload faUpload">
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            value={this.state.image}
                            onChange={this.handleChange.bind(this)}
                            required
                        />
                    </label>
                    <div id="addButton">
                        <button>Add</button>
                    </div>
                </form>
                <div id="serverRendering">
                    <div id="addForm">
                        <h1 id={this.state.success}>{this.state.message}</h1>
                    </div>
                    <div id="data"></div>
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
ReactDOM.render(<Seller />, document.getElementById("app"));
