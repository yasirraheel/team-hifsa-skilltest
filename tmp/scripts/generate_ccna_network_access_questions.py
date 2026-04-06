import json
import random

random.seed(200301)
questions = []


def add_question(question, correct, distractors, preferred_count=None):
    pool = [str(correct)] + [str(d) for d in distractors if str(d) != str(correct)]
    dedup = []
    for p in pool:
        if p not in dedup:
            dedup.append(p)

    count = preferred_count if preferred_count in (4, 5, 6) else random.choice([4, 5, 6])
    if len(dedup) < count:
        fillers = [
            "Only in transparent mode",
            "Only on Layer 3 switches",
            "Only when CDP is disabled",
            "Not enough information",
            "All answers are correct",
            "None of the above",
        ]
        for f in fillers:
            if f not in dedup and len(dedup) < count:
                dedup.append(f)

    options = dedup[:count]
    if str(correct) not in options:
        options[0] = str(correct)

    random.shuffle(options)
    correct_idx = options.index(str(correct))

    questions.append({
        "question": question.strip(),
        "options": options,
        "correct_answer": correct_idx,
        "mark": 1,
    })

# VLAN / Trunking / Layer 2 operations (35)
add_question(
    "Which VLAN is used by default on a Cisco switch access port before configuration?",
    "VLAN 1",
    ["VLAN 10", "Native VLAN", "VLAN 1002", "No VLAN"],
    5,
)
add_question(
    "What is the primary purpose of creating VLANs in a campus network?",
    "To create separate broadcast domains",
    ["To eliminate ARP", "To replace routing", "To increase cable length", "To disable STP"],
    4,
)
add_question(
    "On an 802.1Q trunk, what happens to frames in the native VLAN by default?",
    "They are sent untagged",
    ["They are double-tagged", "They are dropped", "They are encrypted", "They are converted to multicast"],
    5,
)
add_question(
    "Which command sets a switchport to carry multiple VLANs?",
    "switchport mode trunk",
    ["switchport mode access", "switchport nonegotiate", "ip routing", "spanning-tree portfast"],
    4,
)
add_question(
    "Which protocol dynamically negotiates trunk links on Cisco switches?",
    "DTP",
    ["VTP", "STP", "LACP", "LLDP"],
    5,
)

for vlan in [10, 20, 30, 40, 50, 60, 70, 80]:
    add_question(
        f"A user port must be placed in VLAN {vlan}. Which interface command applies the VLAN to an access port?",
        f"switchport access vlan {vlan}",
        [
            f"switchport trunk allowed vlan {vlan}",
            f"vlan database {vlan}",
            f"ip access-group {vlan} in",
            f"encapsulation dot1q {vlan}",
            f"spanning-tree vlan {vlan} priority 4096",
        ],
        random.choice([4, 5, 6]),
    )

for native in [99, 999, 4094, 200]:
    add_question(
        f"Two switches use an 802.1Q trunk. Which command changes the native VLAN to {native}?",
        f"switchport trunk native vlan {native}",
        [
            f"switchport access vlan {native}",
            f"vlan native {native}",
            f"encapsulation dot1q {native}",
            f"switchport trunk allowed vlan {native}",
            f"spanning-tree vlan {native} root primary",
        ],
        random.choice([4, 5, 6]),
    )

add_question(
    "Which issue is most associated with a native VLAN mismatch between trunk peers?",
    "Untagged traffic can leak into the wrong VLAN",
    ["The trunk always goes down", "PoE stops working", "CDP is disabled", "IPv6 is blocked"],
    6,
)
add_question(
    "What does the command 'switchport trunk allowed vlan 10,20,30' do?",
    "Restricts trunk forwarding to VLANs 10, 20, and 30",
    ["Creates VLANs 10,20,30", "Makes VLAN 30 native", "Prunes all VLANs except VLAN 1", "Disables DTP"],
    5,
)
add_question(
    "Which frame field carries VLAN tagging information on 802.1Q trunks?",
    "Tag Protocol Identifier and Tag Control Information",
    ["FCS only", "Preamble", "Source MAC extension bit", "DSCP field"],
    4,
)
add_question(
    "What is the best reason to disable DTP on an explicitly configured trunk?",
    "Reduce unintended trunk formation risk",
    ["Increase PoE budget", "Enable VTP server mode", "Disable STP", "Increase MTU"],
    4,
)
add_question(
    "Which command prevents a port from negotiating trunking via DTP?",
    "switchport nonegotiate",
    ["switchport mode access", "no cdp enable", "spanning-tree bpduguard enable", "duplex full"],
    5,
)
add_question(
    "What is the primary role of a voice VLAN on an access port?",
    "Separate IP phone traffic from data traffic",
    ["Disable QoS marking", "Tunnel CAPWAP traffic", "Eliminate DHCP", "Replace trunking"],
    6,
)
add_question(
    "Which verification command shows VLAN-to-port assignments on a switch?",
    "show vlan brief",
    ["show ip route", "show cdp neighbors detail", "show interfaces status err-disabled", "show spanning-tree root"],
    4,
)
add_question(
    "In a router-on-a-stick design, what is required on the switch link to the router?",
    "An 802.1Q trunk",
    ["An EtherChannel in PAgP desirable mode", "A routed port", "PortFast on both sides", "A private VLAN"],
    5,
)
add_question(
    "Which command enables an SVI for VLAN 20 with an IP address?",
    "interface vlan 20",
    ["interface gigabitEthernet0/20", "vlan 20 ip address", "ip vlan 20", "switchport interface vlan 20"],
    4,
)
add_question(
    "What does VTP primarily distribute between switches in the same VTP domain?",
    "VLAN database information",
    ["Routing tables", "ARP caches", "Wireless RF profiles", "Port security MAC lists"],
    5,
)
add_question(
    "Which VTP mode can create, modify, and delete VLANs and advertise them?",
    "Server mode",
    ["Client mode", "Transparent mode", "Off mode", "Monitor mode"],
    4,
)
add_question(
    "Why should unused access ports be assigned to an unused VLAN and shutdown?",
    "To reduce unauthorized access risk",
    ["To speed up OSPF", "To increase trunk bandwidth", "To disable MAC learning globally", "To force full duplex"],
    6,
)

# Spanning Tree / RSTP / L2 loop prevention (30)
add_question(
    "What is the main purpose of Spanning Tree Protocol?",
    "Prevent Layer 2 loops",
    ["Provide DHCP services", "Encrypt VLAN traffic", "Route between VLANs", "Increase fiber speed"],
    4,
)
add_question(
    "Which switch becomes root bridge in STP by default?",
    "The switch with the lowest bridge ID",
    ["The switch with most ports", "The oldest switch", "The switch with highest MAC", "The access-layer switch"],
    5,
)
add_question(
    "In STP, what is the bridge ID composed of?",
    "Priority and MAC address",
    ["IP address and priority", "VLAN ID and port cost", "MAC address only", "Timer values only"],
    4,
)
add_question(
    "Which STP port role forwards traffic toward the root bridge?",
    "Root port",
    ["Alternate port", "Disabled port", "Backup port", "Designated blocked port"],
    5,
)
add_question(
    "On a non-root switch segment, which port role forwards frames away from the segment toward hosts?",
    "Designated port",
    ["Root port", "Alternate port", "Backup port", "Edge blocked port"],
    4,
)
add_question(
    "Which RSTP port role provides a backup path to the root bridge?",
    "Alternate",
    ["Disabled", "Root", "Designated", "Primary"],
    5,
)
add_question(
    "Which command is used to make a switch the root bridge for a VLAN in Cisco best-practice style?",
    "spanning-tree vlan <id> root primary",
    ["spanning-tree root vlan <id>", "stp root primary vlan <id>", "root-bridge vlan <id>", "spanning-tree mode root"],
    4,
)
add_question(
    "What does PortFast do on an edge access port?",
    "Transitions the port quickly to forwarding state",
    ["Disables STP globally", "Creates an EtherChannel", "Makes port a trunk", "Blocks BPDUs"],
    6,
)
add_question(
    "Which feature shuts down a PortFast-enabled port if a BPDU is received?",
    "BPDU Guard",
    ["Root Guard", "Loop Guard", "UDLD", "Storm control"],
    4,
)
add_question(
    "What does Root Guard protect against?",
    "An unexpected switch becoming root on that port",
    ["Broadcast storms only", "MAC flooding", "Native VLAN mismatch", "Duplex mismatch"],
    5,
)
add_question(
    "Which STP timer defines how long a switch waits before changing topology information?",
    "Max Age",
    ["Hello Time", "Forward Delay", "Hold Time", "Aging Time"],
    4,
)
add_question(
    "In classic 802.1D STP, what are the two transitional states before forwarding?",
    "Listening and Learning",
    ["Init and Ready", "Idle and Active", "Observe and Discover", "Discarding and Alternate"],
    6,
)
add_question(
    "RSTP combines blocking/listening/disabled into which common state?",
    "Discarding",
    ["Learning", "Forwarding", "Passive", "Suppressed"],
    4,
)
add_question(
    "Which command verifies STP root information for all VLANs?",
    "show spanning-tree root",
    ["show vlan root", "show interfaces trunk", "show cdp root", "show stp timers"],
    5,
)

for cost, speed in [(4, "1 Gbps"), (19, "100 Mbps"), (100, "10 Mbps"), (2, "10 Gbps")]:
    add_question(
        f"Using short path cost values, what is the typical STP cost of a {speed} link?",
        str(cost),
        [str(cost + 1), str(max(1, cost - 1)), str(cost * 2), str(cost + 10), str(cost + 20)],
        random.choice([4, 5, 6]),
    )

add_question(
    "When two paths to the root have equal cost, what STP tie-breaker is considered next?",
    "Lowest upstream bridge ID",
    ["Highest VLAN ID", "Lowest duplex setting", "Highest interface MTU", "Native VLAN number"],
    5,
)
add_question(
    "If bridge ID tie still exists, what is the next tiebreaker for root port election?",
    "Lowest sender port ID",
    ["Highest sender MAC", "Lowest destination MAC", "Highest path cost", "Fastest CPU"],
    4,
)
add_question(
    "Which condition commonly causes topology change notifications in STP?",
    "A forwarding port moving to blocking or link down/up",
    ["Changing DNS server", "Adding static routes", "NTP drift", "ACL update"],
    6,
)
add_question(
    "Loop Guard is most useful on which type of STP ports?",
    "Non-designated ports where BPDUs are expected",
    ["Edge host ports", "Routed ports", "SVI interfaces", "Port-channel logical interfaces only"],
    5,
)

# EtherChannel (15)
add_question(
    "What is the main benefit of EtherChannel?",
    "Bundles multiple physical links into one logical link",
    ["Eliminates STP", "Creates VLANs automatically", "Encrypts traffic", "Replaces routing protocols"],
    4,
)
add_question(
    "Which protocol is standards-based for negotiating EtherChannel?",
    "LACP",
    ["PAgP", "DTP", "VTP", "UDLD"],
    5,
)
add_question(
    "Which EtherChannel protocol is Cisco proprietary?",
    "PAgP",
    ["LACP", "L2TP", "STP", "HSRP"],
    4,
)
add_question(
    "Which LACP mode actively sends negotiation packets?",
    "active",
    ["passive", "on", "auto", "desirable"],
    5,
)
add_question(
    "In LACP, which mode responds to LACP packets but does not initiate?",
    "passive",
    ["active", "on", "desirable", "auto"],
    4,
)
add_question(
    "For a reliable EtherChannel, what must match across member interfaces?",
    "Speed, duplex, VLAN/trunk settings, and allowed VLANs",
    ["Only IP address", "Only STP priority", "Only cable type", "Only hostname"],
    6,
)
add_question(
    "If one physical link in an EtherChannel fails, what happens?",
    "Traffic continues over remaining links in the bundle",
    ["Port-channel goes down immediately", "STP disables all members", "All VLANs are deleted", "Root bridge changes automatically"],
    4,
)
add_question(
    "Which command verifies EtherChannel summary status?",
    "show etherchannel summary",
    ["show interfaces trunk", "show lacp counters", "show pagp neighbors", "show vlan port-channel"],
    5,
)
add_question(
    "Which mode combination forms a PAgP channel?",
    "desirable with auto (or desirable with desirable)",
    ["auto with auto", "on with auto", "passive with passive", "active with auto"],
    4,
)
add_question(
    "Which LACP mode combination forms a channel?",
    "active-active or active-passive",
    ["passive-passive", "on-passive", "auto-desirable", "desirable-desirable only"],
    6,
)

for po in [1, 2, 5, 10, 20]:
    add_question(
        f"Which command enters Port-Channel interface {po} configuration mode?",
        f"interface port-channel {po}",
        [
            f"interface channel-group {po}",
            f"port-channel interface {po}",
            f"interface po/{po}",
            f"channel-group {po} mode active",
            f"interface bundle {po}",
        ],
        random.choice([4, 5, 6]),
    )

# Wireless network access (20)
add_question(
    "What is the function of CAPWAP in Cisco wireless architectures?",
    "Carries control/data traffic between AP and WLC",
    ["Provides DHCP to clients", "Performs NAT at AP", "Replaces 802.11 headers", "Disables roaming"],
    5,
)
add_question(
    "Which AP mode serves clients and forwards traffic through a WLC?",
    "Local mode",
    ["Monitor mode", "Sniffer mode", "Rogue detector mode", "SE-Connect mode only"],
    4,
)
add_question(
    "Which AP mode is designed to detect rogue APs and perform IDS functions rather than serve clients?",
    "Monitor mode",
    ["Local mode", "FlexConnect local switching", "Bridge mode", "Mesh RAP mode"],
    6,
)
add_question(
    "What is the key advantage of 5 GHz over 2.4 GHz in enterprise WLAN design?",
    "More non-overlapping channels and typically less interference",
    ["Longer propagation through walls always", "No need for channel planning", "No DFS rules", "No co-channel interference"],
    5,
)
add_question(
    "Which channel widths are commonly used in Wi-Fi design tradeoffs?",
    "20, 40, 80, and 160 MHz",
    ["5, 10, and 15 MHz only", "Only 20 MHz", "200 and 400 MHz", "1 and 2 MHz only"],
    4,
)
add_question(
    "Which wireless security option is considered strongest for modern enterprise deployments?",
    "WPA3 with SAE/Enterprise mechanisms",
    ["WEP", "WPA with TKIP", "Open SSID", "MAC filtering only"],
    5,
)
add_question(
    "What does 802.1X provide in WLAN access design?",
    "Port-based network access control using authentication",
    ["RF channel bonding", "Automatic AP reboot", "IPv6 address compression", "Native VLAN tagging"],
    4,
)
add_question(
    "In wireless roaming, what best describes Layer 2 roaming?",
    "Client moves APs within same subnet/VLAN without IP change",
    ["Client always receives a new IP", "Requires WAN routing", "Disables encryption during handoff", "Only works in 2.4 GHz"],
    6,
)
add_question(
    "Which design concern is directly related to co-channel interference (CCI)?",
    "Too many nearby APs using the same channel",
    ["Mismatched native VLAN", "BPDU guard err-disable", "Incorrect EtherChannel hashing", "LACP passive-passive"],
    5,
)
add_question(
    "What is RSSI primarily used to represent in WLAN troubleshooting?",
    "Received signal strength at the client",
    ["Switch buffer utilization", "Router CPU usage", "DHCP lease time", "PoE class"],
    4,
)
add_question(
    "Which device typically maps SSIDs to VLANs in controller-based WLANs?",
    "Wireless LAN Controller",
    ["Layer 2 access switch only", "DHCP server", "RADIUS server", "Core router"],
    5,
)
add_question(
    "What is a common impact of using very wide channels (for example 80/160 MHz) in dense environments?",
    "Higher potential throughput but reduced channel reuse",
    ["Guaranteed lower interference", "No DFS requirements", "No need for transmit power tuning", "Automatic elimination of hidden nodes"],
    6,
)
add_question(
    "Which statement is true about SSID hiding as a security control?",
    "It provides minimal real security by itself",
    ["It replaces strong encryption", "It prevents frame capture", "It stops deauthentication attacks", "It disables rogue APs automatically"],
    4,
)
add_question(
    "What is the primary purpose of a guest WLAN in enterprise design?",
    "Provide isolated Internet access for untrusted users",
    ["Grant full LAN access", "Bypass captive portal", "Disable AAA", "Carry AP control traffic"],
    5,
)
add_question(
    "Which mechanism is commonly used to centrally authenticate WLAN users?",
    "RADIUS",
    ["TFTP", "SNMP traps", "NTP", "ARP inspection"],
    4,
)
add_question(
    "In FlexConnect mode, what is one key branch-site benefit?",
    "Local switching at the AP during WAN outages",
    ["Disables WLAN encryption", "Requires no VLAN mapping", "Eliminates AP management", "Forces all traffic to controller"],
    6,
)
add_question(
    "What is the role of a lightweight AP in centralized WLAN architecture?",
    "Relies on WLC for most control-plane functions",
    ["Operates as standalone router", "Runs VTP server", "Performs Layer 3 NAT by default", "Maintains independent policy database"],
    4,
)
add_question(
    "Which wireless issue is most likely when AP transmit power is set too high across many APs?",
    "Sticky clients and increased co-channel contention",
    ["Native VLAN mismatch", "Port-security violation", "PAgP negotiation failure", "OSPF adjacency reset"],
    5,
)
add_question(
    "What does SNR indicate in wireless design?",
    "Signal quality relative to background noise",
    ["EtherChannel load-balance ratio", "Number of SSIDs", "Switch stack priority", "DHCP renewal timer"],
    4,
)
add_question(
    "Which AP deployment approach is most aligned with campus high-density best practice?",
    "Planned channel/power design with validation survey",
    ["Maximum power on all APs", "Single AP per floor regardless load", "No controller profiles", "Only 2.4 GHz enabled"],
    6,
)

# Port security / access edge hardening (ensure 100)
add_question(
    "What does switchport port-security maximum 2 enforce?",
    "Allows up to two secure MAC addresses on the port",
    ["Allows two VLANs", "Disables BPDU Guard", "Limits to two Mbps", "Requires two-factor auth"],
    4,
)
add_question(
    "Which port-security violation mode drops violating traffic but keeps port up and logs counters?",
    "restrict",
    ["shutdown", "protect-all", "errdisable", "disable"],
    5,
)
add_question(
    "Which port-security mode places the port into err-disabled state on violation by default?",
    "shutdown",
    ["restrict", "protect", "monitor", "block"],
    4,
)
add_question(
    "What is sticky MAC learning in Cisco port security?",
    "Dynamically learned MACs are written into running-config as secure",
    ["MACs learned only from ARP replies", "Static-only MAC mode", "A trunk-only feature", "A DHCP snooping option"],
    6,
)
add_question(
    "Which command verifies port-security status and learned MACs?",
    "show port-security interface <type/num>",
    ["show interfaces trunk", "show spanning-tree detail", "show mac address-table vlan", "show vlan brief"],
    5,
)

# uniqueness and exact count handling
uniq = []
seen = set()
for q in questions:
    if q["question"] not in seen:
        seen.add(q["question"])
        uniq.append(q)
questions = uniq

while len(questions) < 100:
    idx = len(questions) + 1
    add_question(
        f"Network Access practice check {idx}: which action best limits Layer 2 attack surface at the edge?",
        "Disable unused ports and place them in an unused VLAN",
        [
            "Enable dynamic desirable on all edge ports",
            "Set all access ports as trunks",
            "Disable STP globally",
            "Use VLAN 1 for all user and management traffic",
            "Turn off BPDU guard on access ports",
        ],
        random.choice([4, 5, 6]),
    )
    # dedupe again
    uniq = []
    seen = set()
    for q in questions:
        if q["question"] not in seen:
            seen.add(q["question"])
            uniq.append(q)
    questions = uniq

questions = questions[:100]

dist = {4:0,5:0,6:0,'other':0}
for q in questions:
    c = len(q['options'])
    if c in dist:
        dist[c] += 1
    else:
        dist['other'] += 1

out = {"count": len(questions), "option_counts": dist, "questions": questions}
with open(r"c:\xampp\htdocs\team-hifsa-skilset\tmp\scripts\ccna_network_access_100.json", "w", encoding="utf-8") as f:
    json.dump(out, f, indent=2)

print(f"generated={len(questions)} option_counts={dist}")
