<p align="center">
<a href="https://peeriodproject.github.io"><img src="https://peeriodproject.github.io/dl/peeriod-img.png" /></a>
</p>

Peeriod is an open source project which strives for making privacy protected peer-to-peer file sharing available to the masses.
Peeriod’s aim is to construct Onion Routing on top of a DHT, while at the same time avoiding certificate authorities. Each node is equally (un)trustworthy and can act as a relay node for encrypted traffic. A flooding-based search takes advantage of the DHT’s structure and provides full-text search capabilities.

[peeriodproject.org](http://peeriodproject.org)

[View the conceptual paper (PDF)](https://peeriodproject.github.io/dl/Peeriod_Anonymous_decentralized_network.pdf)

[View the application design specification (PDF)](https://peeriodproject.github.io/dl/Peeriod_Anonymous_decentralized_network.pdf)

---

# PHP MySQL - Node Discovery Server

Very basic PHP implementation for a HTTP node discovery server which is currently used to find an initial entry node.

If you want to provide a node discovery server yourself, adjust the credentials in `db.inc` and put it somewhere outside your webroot. Then specify the relative path stored in the variable `$pathToDbInc` in both index.php and build.php.

Run build.php once to construct the table structure. Delete the file afterwards and [tell us](https://peeriodproject.github.io/contact) about your node discovery server.
