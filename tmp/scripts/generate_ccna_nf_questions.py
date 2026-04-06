import ipaddress
import json
import random

random.seed(3011)
questions = []


def gen_fillers(answer, needed):
    vals = []
    if answer.isdigit():
        a = int(answer)
        for delta in [1, 2, -1, -2, 4, -4, 8, -8]:
            v = a + delta
            if v > 0:
                vals.append(str(v))
    else:
        vals = [
            "All of the above",
            "None of the above",
            "Only A and C",
            "Only B and D",
            "Not enough information",
        ]
    return vals[:needed]


def normalize_options(answer, options, min_count=4):
    dedup = []
    for o in options:
        s = str(o)
        if s not in dedup:
            dedup.append(s)
    if answer not in dedup:
        dedup.insert(0, answer)

    if len(dedup) < min_count:
        for f in gen_fillers(answer, min_count - len(dedup) + 3):
            if f != answer and f not in dedup:
                dedup.append(f)
            if len(dedup) >= min_count:
                break
    return dedup


def add_question(q, options, answer):
    opts = normalize_options(str(answer), options)
    random.shuffle(opts)
    correct = opts.index(str(answer))
    questions.append({
        "question": q.strip(),
        "options": opts,
        "correct_answer": correct,
        "mark": 1,
    })

prefixes = [25, 26, 27, 28, 29, 30, 24, 23, 22, 21]
for p in prefixes:
    hosts = (2 ** (32 - p)) - 2
    distractors = sorted(set([
        max(1, hosts // 2),
        hosts + 2,
        max(1, hosts - 2),
        (2 ** (32 - p)),
        max(1, (2 ** (32 - p - 1)) - 2) if p < 30 else 1,
    ]))
    opts = [str(hosts)] + [str(x) for x in distractors if x != hosts]
    add_question(
        f"How many usable host addresses are available in an IPv4 /{p} subnet?",
        opts[:6],
        str(hosts),
    )

cases = [
    "10.10.34.77/27", "172.16.99.201/28", "192.168.50.130/25", "10.1.1.254/24",
    "172.20.14.62/26", "192.0.2.99/27", "198.51.100.241/29", "203.0.113.17/30",
    "10.8.200.11/20", "172.31.255.200/21", "192.168.7.190/26", "10.44.12.199/23",
    "172.18.5.129/25", "192.168.120.77/28", "10.10.10.10/30", "172.25.100.220/27",
    "192.168.1.65/26", "10.200.14.9/29", "172.19.33.145/27", "192.168.88.222/28",
]
for cidr in cases:
    iface = ipaddress.ip_interface(cidr)
    net = iface.network
    ip = iface.ip
    base = int(net.network_address)
    size = net.num_addresses
    candidates = [
        str(net.network_address),
        str(ipaddress.ip_address(base + size if base + size <= 0xFFFFFFFF else base)),
        str(ipaddress.ip_address(base - size if base - size >= 0 else base)),
        str(ipaddress.ip_address(base + (size // 2 if size > 2 else 1))),
        str(ipaddress.ip_address(base + max(1, size - 1))),
        str(ipaddress.ip_address(base + 1 if size > 2 else base)),
    ]
    add_question(
        f"A host has IP {ip} with prefix /{net.prefixlen}. What is the network address of this subnet?",
        candidates,
        str(net.network_address),
    )

planning = [
    ("A PC is 192.168.40.54/24. Which default gateway is valid for this host?", ["192.168.40.1", "192.168.41.1", "192.168.40.255", "127.0.0.1"], "192.168.40.1"),
    ("Which two addresses are valid host addresses in subnet 10.10.8.0/22? (Choose the best pair)", ["10.10.8.1 and 10.10.11.254", "10.10.7.1 and 10.10.8.2", "10.10.8.0 and 10.10.11.255", "10.10.12.1 and 10.10.9.9"], "10.10.8.1 and 10.10.11.254"),
    ("Which prefix should be used if a LAN needs at least 500 usable IPv4 hosts?", ["/23", "/24", "/25", "/22", "/26"], "/23"),
    ("What is the wildcard mask for 255.255.255.224?", ["0.0.0.31", "0.0.0.63", "255.255.255.31", "0.0.31.255"], "0.0.0.31"),
    ("Which route summary best covers 192.168.32.0/24 through 192.168.39.0/24?", ["192.168.32.0/21", "192.168.32.0/20", "192.168.0.0/16", "192.168.32.0/22"], "192.168.32.0/21"),
    ("Which address is APIPA?", ["169.254.22.10", "172.16.10.1", "10.254.1.1", "192.168.254.1"], "169.254.22.10"),
    ("A /26 subnet increments by how many addresses in the fourth octet?", ["64", "32", "16", "128", "8"], "64"),
    ("Which mask corresponds to /19?", ["255.255.224.0", "255.255.240.0", "255.255.248.0", "255.255.192.0"], "255.255.224.0"),
    ("Which subnet contains host 172.16.77.190/20?", ["172.16.64.0/20", "172.16.80.0/20", "172.16.76.0/20", "172.16.0.0/20", "172.16.77.0/20"], "172.16.64.0/20"),
    ("How many /30 subnets can be created from one /24 network?", ["64", "32", "128", "16", "256"], "64"),
    ("Which statement about private IPv4 addresses is correct?", ["They are not routed on the public Internet", "They are globally unique and routable", "They are only used by loopback interfaces", "They must be publicly registered"], "They are not routed on the public Internet"),
    ("Which is a valid host in 192.168.10.64/27?", ["192.168.10.94", "192.168.10.63", "192.168.10.95", "192.168.10.96"], "192.168.10.94"),
    ("A subnet has mask 255.255.255.248. What is the prefix length?", ["/29", "/30", "/28", "/27"], "/29"),
    ("Which block is RFC1918 private?", ["172.16.0.0/12", "172.32.0.0/12", "11.0.0.0/8", "100.64.0.0/10"], "172.16.0.0/12"),
    ("Which is the broadcast address for 10.10.10.128/26?", ["10.10.10.191", "10.10.10.255", "10.10.10.127", "10.10.10.190", "10.10.10.129"], "10.10.10.191"),
]
for q, opts, ans in planning:
    add_question(q, opts, ans)

ipv6_questions = [
    ("Which IPv6 prefix identifies a link-local address?", ["fe80::/10", "fc00::/7", "2000::/3", "ff00::/8"], "fe80::/10"),
    ("Which IPv6 address type is routable on the Internet?", ["Global unicast", "Link-local", "Unique local", "Multicast only"], "Global unicast"),
    ("What does SLAAC use to automatically assign hosts an IPv6 address?", ["Router Advertisements", "DHCPDISCOVER", "ARP", "NAT"], "Router Advertisements"),
    ("Which protocol replaces ARP in IPv6 for address resolution?", ["NDP", "RARP", "ICMPv4", "LLDP"], "NDP"),
    ("What is the shortest valid representation of 2001:0db8:0000:0000:0000:0000:0000:0001?", ["2001:db8::1", "2001::db8::1", "2001:db8:0:0:0:0:0:1", "2001:db8:1::"], "2001:db8::1"),
    ("Which IPv6 prefix length is most common for LAN interfaces?", ["/64", "/48", "/56", "/126", "/128"], "/64"),
    ("Which statement about IPv6 ULA addresses is correct?", ["They are typically used for private internal networks", "They are equivalent to IPv4 APIPA", "They are publicly routable globally", "They are only for multicast"], "They are typically used for private internal networks"),
    ("What is the IPv6 loopback address?", ["::1", "::", "fe80::1", "2001::1"], "::1"),
    ("What does :: represent in IPv6?", ["Unspecified address", "Loopback", "All routers multicast", "Default gateway"], "Unspecified address"),
    ("Which is a valid IPv6 multicast prefix?", ["ff00::/8", "fe80::/10", "2000::/3", "fc00::/7"], "ff00::/8"),
    ("In EUI-64, what is modified in the MAC-derived interface ID?", ["The 7th bit (U/L bit) is inverted", "The OUI is removed", "All Fs are replaced with zeros", "The last octet is dropped"], "The 7th bit (U/L bit) is inverted"),
    ("Which IPv6 address is link-local?", ["fe80::2c4d:1", "2001:db8::10", "fd00::10", "ff02::1"], "fe80::2c4d:1"),
    ("Which mechanism allows IPv6-only hosts to reach IPv4-only services using DNS64 and NAT64?", ["NAT64", "6to4", "Teredo", "ISATAP"], "NAT64"),
    ("What is the purpose of Duplicate Address Detection (DAD)?", ["Verify an IPv6 address is unique on the link", "Select the best default gateway", "Encrypt neighbor traffic", "Determine MTU"], "Verify an IPv6 address is unique on the link"),
    ("Which ICMPv6 message type is used for Router Solicitation?", ["Type 133", "Type 134", "Type 135", "Type 136"], "Type 133"),
    ("Which ICMPv6 message carries prefix and gateway information for SLAAC?", ["Router Advertisement", "Neighbor Solicitation", "Echo Reply", "Destination Unreachable"], "Router Advertisement"),
    ("An IPv6 /56 allocation to a site allows how many /64 subnets?", ["256", "64", "128", "512", "1024"], "256"),
    ("Which address is an example of ULA?", ["fd12:3456:789a::1", "2001:db8::1", "fe80::1", "ff02::1"], "fd12:3456:789a::1"),
    ("What is the equivalent IPv6 concept to IPv4 broadcast?", ["IPv6 uses multicast instead of broadcast", "All packets are unicast", "Anycast replaces both", "Neighbor Discovery uses broadcast"], "IPv6 uses multicast instead of broadcast"),
    ("Which IPv6 address scope is valid only on the local link and not forwarded by routers?", ["Link-local", "Global unicast", "Unique local", "Anycast"], "Link-local"),
]
for q, opts, ans in ipv6_questions:
    add_question(q, opts, ans)

concepts = [
    ("At which OSI layer does a switch make forwarding decisions using MAC addresses?", ["Layer 2", "Layer 1", "Layer 3", "Layer 4"], "Layer 2"),
    ("Which address is used by Ethernet switches for frame forwarding inside a VLAN?", ["Destination MAC address", "Destination IP address", "Source IP address", "TCP port"], "Destination MAC address"),
    ("What is the default behavior of an access switch port?", ["Belongs to one VLAN and sends untagged frames", "Carries multiple VLANs with 802.1Q tags", "Uses routed port mode", "Runs STP disabled by default"], "Belongs to one VLAN and sends untagged frames"),
    ("What is the purpose of a native VLAN on an 802.1Q trunk?", ["Carry untagged traffic", "Carry management traffic only", "Encrypt traffic", "Provide PoE"], "Carry untagged traffic"),
    ("Which duplex mismatch symptom is most likely?", ["Late collisions and poor throughput", "Link goes administratively down", "MAC table overflow", "PoE overload"], "Late collisions and poor throughput"),
    ("Which cable type is typically used for 1000BASE-SX?", ["Multimode fiber", "Single-mode fiber only", "Cat3 UTP", "Coaxial"], "Multimode fiber"),
    ("Which statement about PoE is correct?", ["Power and data can be delivered over the same Ethernet cable", "PoE requires fiber", "PoE works only at 1 Gbps", "PoE is a Layer 3 protocol"], "Power and data can be delivered over the same Ethernet cable"),
    ("What is the function of a wireless LAN controller (WLC)?", ["Centralized management of APs", "Route between VLANs", "Perform NAT for clients", "Replace RADIUS"], "Centralized management of APs"),
    ("Which 2.4 GHz non-overlapping channels are commonly used?", ["1, 6, and 11", "1, 5, and 9", "2, 7, and 12", "3, 8, and 13"], "1, 6, and 11"),
    ("Which Wi-Fi band generally offers more non-overlapping channels and less interference?", ["5 GHz", "2.4 GHz", "900 MHz", "Both are equal"], "5 GHz"),
    ("What does SSID identify in a WLAN?", ["The wireless network name", "The AP MAC address", "The encryption key", "The RF channel width"], "The wireless network name"),
    ("Which architecture is most associated with east-west traffic in modern data centers?", ["Spine-leaf", "Three-tier campus", "Hub-and-spoke", "Collapsed core"], "Spine-leaf"),
    ("In a three-tier campus design, which layer applies policies and route summarization?", ["Distribution layer", "Access layer", "Core layer", "Physical layer"], "Distribution layer"),
    ("Which TCP feature provides reliable, ordered delivery?", ["Sequence numbers and acknowledgments", "Best-effort forwarding", "Broadcast discovery", "Stateless header compression"], "Sequence numbers and acknowledgments"),
    ("Which transport protocol is typically used by DNS queries?", ["UDP", "TCP", "SCTP", "ICMP"], "UDP"),
    ("Which transport protocol does HTTPS primarily use?", ["TCP", "UDP", "ICMP", "ARP"], "TCP"),
    ("What identifies an application process at Layer 4?", ["Port number", "MAC address", "VLAN ID", "DSCP"], "Port number"),
    ("Which OSI layer is responsible for logical addressing and routing?", ["Layer 3", "Layer 2", "Layer 4", "Layer 7"], "Layer 3"),
    ("What happens when a frame enters a switch port assigned to VLAN 20?", ["It is forwarded only within VLAN 20 unless routed", "It is broadcast to all VLANs", "It is automatically NATed", "It is encapsulated in GRE"], "It is forwarded only within VLAN 20 unless routed"),
    ("Which statement best describes microsegmentation in virtualized environments?", ["Policy enforcement between workloads in the same subnet", "Subnetting with /30 links only", "Physical separation with dedicated switches", "Using only ACLs on WAN edge"], "Policy enforcement between workloads in the same subnet"),
    ("Which MAC address type maps one sender to many receivers in Ethernet?", ["Broadcast FF:FF:FF:FF:FF:FF", "Unicast", "Anycast", "Loopback"], "Broadcast FF:FF:FF:FF:FF:FF"),
    ("Which topology provides high availability by using dual-homed access switches to distribution switches?", ["Redundant two-tier design", "Bus topology", "Single-homed star only", "Ring without redundancy"], "Redundant two-tier design"),
    ("What is the key reason to disable unused switch ports?", ["Reduce attack surface", "Increase PoE budget", "Improve OSPF convergence", "Enable NAT"], "Reduce attack surface"),
    ("Which metric is commonly used to describe wireless signal quality at the client?", ["RSSI/SNR", "TTL", "MSS", "ARP age"], "RSSI/SNR"),
    ("Which cable issue can cause CRC errors and intermittent link flaps?", ["Bad termination or excessive EMI", "Correct duplex and speed", "Using a management VLAN", "Using DHCP"], "Bad termination or excessive EMI"),
]
for q, opts, ans in concepts:
    add_question(q, opts, ans)

while len(questions) < 100:
    prefix = random.choice([26, 27, 28, 29])
    third = random.randint(0, 255)
    fourth = random.choice([0, 32, 64, 96, 128, 160, 192, 224])
    net = ipaddress.ip_network(f"10.{third}.{fourth}.0/{prefix}", strict=False)
    host = list(net.hosts())[0]
    base = int(net.network_address)
    size = net.num_addresses
    answer = str(net.network_address)
    opts = [
        answer,
        str(ipaddress.ip_address(min(0xFFFFFFFF, base + size))),
        str(ipaddress.ip_address(max(0, base - size))),
        str(ipaddress.ip_address(min(0xFFFFFFFF, base + 1))),
        str(ipaddress.ip_address(min(0xFFFFFFFF, base + (size // 2)))),
        str(ipaddress.ip_address(min(0xFFFFFFFF, base + max(1, size - 1)))),
    ]
    count = random.choice([4, 5, 6])
    add_question(
        f"A host with address {host}/{prefix} is in which network?",
        opts[:count],
        answer,
    )

uniq = []
seen = set()
for item in questions:
    if item['question'] not in seen:
        seen.add(item['question'])
        uniq.append(item)
questions = uniq

while len(questions) < 100:
    idx = len(questions) + 1
    q = f"In IPv4 planning, what is one key reason to use VLSM? (Set {idx})"
    if q in seen:
        continue
    add_question(
        q,
        [
            "Efficient address allocation by matching subnet size to need",
            "To eliminate the need for routing",
            "To make all subnets the same size",
            "To replace IPv6",
        ],
        "Efficient address allocation by matching subnet size to need",
    )
    seen.add(q)

questions = questions[:100]

# Ensure 4-6 options and valid correct index
for item in questions:
    answer = item['options'][item['correct_answer']]
    item['options'] = normalize_options(answer, item['options'], 4)
    if len(item['options']) > 6:
        item['options'] = item['options'][:6]
        if answer not in item['options']:
            item['options'][0] = answer
    random.shuffle(item['options'])
    item['correct_answer'] = item['options'].index(answer)

counts = {4:0,5:0,6:0}
for item in questions:
    counts[len(item['options'])] = counts.get(len(item['options']), 0) + 1

out = {"count": len(questions), "option_counts": counts, "questions": questions}
with open(r"c:\xampp\htdocs\team-hifsa-skilset\tmp\scripts\ccna_network_fundamentals_100.json", "w", encoding="utf-8") as f:
    json.dump(out, f, indent=2)
print(f"generated={len(questions)} option_counts={counts}")
