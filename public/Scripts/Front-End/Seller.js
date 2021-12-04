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
            // Input
            name: "",
            // Output
            success: "",
            message: "",
            url: "",
            content: "",
            data: [],
        };
    }
    // Retrieve Data method
    retrieveData() {
        // Generating a GET request
        fetch("./SellerGET.php", {
            method: "GET",
        })
            .then((response) => response.json())
            .then((data) =>
                this.setState({
                    content: data.content,
                    data: data.data,
                })
            );
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
        const delay = 1800;
        // Prevent default submission
        event.preventDefault();
        // Generating a POST request
        fetch("./SellerPOST.php", {
            method: "POST",
            body: JSON.stringify({
                name: this.state.name,
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
    // Component Did Mount method
    componentDidMount() {
        // Retrieving the data from the database
        this.retrieveData();
    }
    // Render method
    render() {
        return (
            <main>
                <form method="POST" onSubmit={this.handleSubmit.bind(this)}>
                    <div id="label">Adding items</div>
                    <input
                        type="text"
                        name="name"
                        placeholder="Name"
                        value={this.state.name}
                        onChange={this.handleChange.bind(this)}
                        required
                    />
                    <div id="addButton">
                        <button>Add</button>
                    </div>
                </form>
                <div id="serverRendering">
                    <div id="addForm">
                        <h1 id={this.state.success}>{this.state.message}</h1>
                    </div>
                    <div id={this.state.content}>
                        {this.state.data.map((data) => (
                            <div class="dataItem">
                                <div class="dataItemImage">
                                    <img
                                        src={data.ItemImage}
                                        alt={data.ItemId}
                                    />
                                </div>
                                <div class="dataItemData">
                                    <div>
                                        <h1>{data.ItemName}</h1>
                                    </div>
                                    <div>
                                        <h1>$ {data.ItemPrice}</h1>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
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
