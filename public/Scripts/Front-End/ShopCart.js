// Buyer class
class Buyer extends React.Component {
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
                <nav>
                    <div>
                        <a href="./" class="fas fa-shopping-cart faCart"></a>
                    </div>
                    <div>
                        <a href="../Profile" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a
                            href="../Logout"
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
            content: "",
            data: 0.0,
        };
    }
    // Retrieve Data method
    retrieveData() {
        // Generating a GET request
        fetch("./ShopCartGET.php", {
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
    // Component Did Mount method
    componentDidMount() {
        // Retrieving data from the database
        this.retrieveData();
    }
    // Render method
    render() {
        return (
            <main>
                <div id={this.state.content}>
                    <div class="dataItem">
                        <div class="dataItemData">
                            <div>
                                <h1>
                                    Net Worth: $ {this.state.data.toFixed(2)}
                                </h1>
                            </div>
                        </div>
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
ReactDOM.render(<Buyer />, document.getElementById("app"));
