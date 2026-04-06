import json
import random

random.seed(20030111)
questions = []


def unique(items):
    seen = set()
    out = []
    for item in items:
        if item not in seen:
            seen.add(item)
            out.append(item)
    return out


def add_single(question, correct, distractors, explanation, option_count=4):
    options = unique([correct] + distractors)
    if len(options) < option_count:
        raise RuntimeError(f"Not enough options for: {question}")
    options = options[:option_count]
    random.shuffle(options)
    questions.append(
        {
            "question": question.strip(),
            "options": options,
            "correct_answers": [options.index(correct)],
            "mark": 1,
            "explanation": explanation.strip(),
        }
    )


def add_multi(question, correct, distractors, explanation, option_count=5):
    options = unique(correct + distractors)
    if len(options) < option_count:
        raise RuntimeError(f"Not enough options for: {question}")
    options = options[:option_count]
    random.shuffle(options)
    answers = sorted(options.index(item) for item in correct)
    questions.append(
        {
            "question": question.strip(),
            "options": options,
            "correct_answers": answers,
            "mark": 1,
            "explanation": explanation.strip(),
        }
    )


# ---------------------------------------------------------------------------
# 1) Route selection / RIB behavior (22)
# ---------------------------------------------------------------------------
lpm_cases = [
    ("10.10.20.9", "10.10.20.0/24 via G0/1", "10.10.0.0/16 via G0/0", "0.0.0.0/0 via G0/3"),
    ("172.16.31.77", "172.16.31.64/26 via G0/2", "172.16.31.0/24 via G0/1", "0.0.0.0/0 via G0/3"),
    ("192.168.14.130", "192.168.14.128/25 via G0/1", "192.168.14.0/24 via G0/0", "0.0.0.0/0 via G0/3"),
    ("198.51.100.67", "198.51.100.64/27 via G0/1", "198.51.100.0/24 via G0/0", "0.0.0.0/0 via G0/3"),
    ("203.0.113.201", "203.0.113.192/27 via G0/2", "203.0.113.0/24 via G0/1", "0.0.0.0/0 via G0/3"),
    ("10.44.8.190", "10.44.8.128/25 via G0/3", "10.44.8.0/24 via G0/2", "0.0.0.0/0 via G0/0"),
    ("172.20.5.15", "172.20.5.0/28 via G0/0", "172.20.5.0/24 via G0/1", "0.0.0.0/0 via G0/3"),
    ("192.0.2.126", "192.0.2.64/26 via G0/1", "192.0.2.0/24 via G0/0", "0.0.0.0/0 via G0/3"),
    ("10.120.14.9", "10.120.14.0/24 via G0/2", "10.120.0.0/16 via G0/1", "0.0.0.0/0 via G0/3"),
    ("172.31.240.34", "172.31.240.32/27 via G0/2", "172.31.240.0/24 via G0/1", "0.0.0.0/0 via G0/3"),
    ("10.5.1.60", "10.5.1.32/27 via G0/2", "10.5.1.0/24 via G0/1", "0.0.0.0/0 via G0/0"),
    ("172.18.200.130", "172.18.200.128/25 via G0/1", "172.18.200.0/24 via G0/0", "0.0.0.0/0 via G0/2"),
]

for dest, best, broad, default in lpm_cases:
    add_single(
        question=f"For destination {dest}, which route is selected if all listed entries exist?",
        correct=best,
        distractors=[broad, "10.0.0.0/8 via G0/2", default],
        explanation=(
            f"Routers use longest-prefix match first. {best} is the most specific matching prefix, "
            "so it wins over broader routes and the default route."
        ),
    )

ad_cases = [
    ("10.50.10.0/24", "static (AD 1)", ["OSPF (AD 110)", "RIP (AD 120)", "EIGRP internal (AD 90)"]),
    ("172.16.40.0/24", "eBGP (AD 20)", ["OSPF (AD 110)", "RIP (AD 120)", "EIGRP internal (AD 90)"]),
    ("192.168.70.0/24", "EIGRP internal (AD 90)", ["OSPF (AD 110)", "RIP (AD 120)", "iBGP (AD 200)"]),
    ("10.10.88.0/24", "static (AD 5)", ["OSPF (AD 110)", "RIP (AD 120)", "EIGRP external (AD 170)"]),
    ("172.22.1.0/24", "EIGRP internal (AD 90)", ["OSPF (AD 110)", "RIP (AD 120)", "iBGP (AD 200)"]),
    ("198.51.100.0/24", "connected (AD 0)", ["static (AD 1)", "OSPF (AD 110)", "RIP (AD 120)"]),
    ("203.0.113.0/24", "EIGRP internal (AD 90)", ["OSPF (AD 110)", "RIP (AD 120)", "static (AD 200)"]),
    ("10.77.32.0/24", "OSPF (AD 110)", ["floating static (AD 130)", "RIP (AD 120)", "iBGP (AD 200)"]),
    ("172.30.30.0/24", "static (AD 10)", ["OSPF (AD 110)", "RIP (AD 120)", "EIGRP internal (AD 90)"]),
    ("192.0.2.0/24", "OSPF (AD 110)", ["RIP (AD 120)", "iBGP (AD 200)", "floating static (AD 250)"]),
]

for prefix, best, others in ad_cases:
    add_single(
        question=f"The prefix {prefix} is learned from multiple sources with same mask. Which route is installed?",
        correct=best,
        distractors=others,
        explanation=(
            "When prefix length is equal, the route with lowest administrative distance is chosen. "
            f"For this case, {best} has the best AD."
        ),
    )

misc_route_items = [
    (
        "What does 'S 0.0.0.0/0 [1/0] via 10.1.1.1' indicate in a routing table?",
        "A static default route with AD 1 toward next-hop 10.1.1.1",
        ["A connected host route", "An OSPF external route", "A floating static with AD 254"],
        "Code S means static, 0.0.0.0/0 is default, and [1/0] shows AD 1 metric 0. This is the primary static default path.",
    ),
    (
        "What does route code 'L' represent in show ip route output?",
        "A local /32 route for the router interface IP",
        ["A loopback summary", "A leaked route", "A load-balanced route"],
        "Code L is auto-created for each interface IP address so packets to the router's own address are delivered locally.",
    ),
]

for q, c, d, e in misc_route_items:
    add_single(q, c, d, e)


# ---------------------------------------------------------------------------
# 2) Static routing IPv4/IPv6 and failover (28)
# ---------------------------------------------------------------------------
ipv4_cases = [
    ("192.168.50.0", "255.255.255.0", "10.1.1.2"),
    ("172.20.14.0", "255.255.255.0", "10.2.2.2"),
    ("10.44.88.0", "255.255.255.0", "192.0.2.2"),
    ("192.168.120.0", "255.255.255.128", "10.3.3.2"),
    ("172.31.240.0", "255.255.255.224", "10.4.4.2"),
    ("198.51.100.0", "255.255.255.0", "10.5.5.2"),
    ("203.0.113.64", "255.255.255.192", "10.6.6.2"),
    ("10.200.14.0", "255.255.255.0", "10.7.7.2"),
    ("172.18.5.128", "255.255.255.192", "10.8.8.2"),
    ("192.168.77.0", "255.255.255.0", "10.9.9.2"),
]

for net, mask, nh in ipv4_cases:
    cmd = f"ip route {net} {mask} {nh}"
    add_single(
        question=f"Which command correctly adds a static route to {net} with mask {mask} via {nh}?",
        correct=cmd,
        distractors=[
            f"ip route {net} {nh} {mask}",
            f"ip default-gateway {nh}",
            f"route ip {net} {mask} {nh}",
        ],
        explanation=(
            "IPv4 static syntax is 'ip route <network> <mask> <next-hop|interface>'. "
            f"{cmd} matches that exact format."
        ),
    )

floating_cases = [
    ("10.10.10.0", "255.255.255.0", "192.0.2.10", 130),
    ("172.16.88.0", "255.255.255.0", "192.0.2.14", 150),
    ("192.168.77.0", "255.255.255.0", "192.0.2.18", 140),
    ("10.44.44.0", "255.255.255.0", "192.0.2.22", 200),
]

for net, mask, nh, ad in floating_cases:
    cmd = f"ip route {net} {mask} {nh} {ad}"
    add_single(
        question=f"Which command configures a floating static route to {net} via {nh} with AD {ad}?",
        correct=cmd,
        distractors=[
            f"ip route {net} {mask} {nh}",
            f"ip route {net} {nh} {mask} {ad}",
            f"ip route {net} {mask} {ad} {nh}",
        ],
        explanation=(
            "A floating static route is just a static route with a higher administrative distance value at the end. "
            f"The correct IOS format is: {cmd}."
        ),
    )

static_concepts = [
    (
        "Which command creates IPv4 default route via 10.10.10.1?",
        "ip route 0.0.0.0 0.0.0.0 10.10.10.1",
        ["ip route default 10.10.10.1", "ip default-network 10.10.10.1", "ip route 255.255.255.255 0.0.0.0 10.10.10.1"],
        "IPv4 default is 0.0.0.0/0, so static default route must use 0.0.0.0 and 0.0.0.0 as destination and mask.",
    ),
    (
        "Which command creates a host route to only 192.168.99.77 via 10.1.1.1?",
        "ip route 192.168.99.77 255.255.255.255 10.1.1.1",
        ["ip route 192.168.99.0 255.255.255.0 10.1.1.1", "ip route 192.168.99.77 255.255.255.0 10.1.1.1", "ip route 0.0.0.0 0.0.0.0 10.1.1.1"],
        "A host route is /32, so the subnet mask must be 255.255.255.255 to match exactly one IP.",
    ),
    (
        "How do you remove static route 'ip route 10.10.50.0 255.255.255.0 192.0.2.5'?",
        "no ip route 10.10.50.0 255.255.255.0 192.0.2.5",
        ["delete ip route 10.10.50.0 255.255.255.0 192.0.2.5", "clear ip route 10.10.50.0 255.255.255.0 192.0.2.5", "undo ip route 10.10.50.0 255.255.255.0 192.0.2.5"],
        "IOS removes configuration by prefixing the exact original line with 'no'.",
    ),
    (
        "Branch reaches HQ but HQ cannot initiate traffic to branch LAN. Most likely issue?",
        "Missing return route from HQ toward branch subnet",
        ["STP priority problem", "DHCP exclusion misconfiguration", "Voice VLAN mismatch"],
        "This symptom usually means forward path exists but reverse path does not. Add or advertise the return route.",
    ),
    (
        "Why use a summary static route to Null0?",
        "To discard traffic to unknown sub-prefixes inside the summary and avoid loops",
        ["To accelerate OSPF hellos", "To force static AD to 1", "To disable ECMP"],
        "A summary can attract traffic for subnets that do not exist. Null0 safely drops those unmatched destinations.",
    ),
    (
        "On multi-access Ethernet, why can next-hop-only static be better than interface-only static?",
        "It avoids unnecessary ARP for every destination in that route",
        ["It disables recursive lookup completely", "It guarantees DR election", "It replaces OSPF process ID"],
        "Interface-only static on multi-access can trigger ARP for many hosts. Specifying next-hop improves behavior and clarity.",
    ),
]

for q, c, d, e in static_concepts:
    add_single(q, c, d, e)

ipv6_cases = [
    ("2001:db8:10:10::/64", "2001:db8:0:1::2"),
    ("2001:db8:20:20::/64", "2001:db8:0:2::2"),
    ("2001:db8:30:30::/64", "2001:db8:0:3::2"),
    ("2001:db8:40:40::/64", "2001:db8:0:4::2"),
    ("2001:db8:50:50::/64", "2001:db8:0:5::2"),
    ("2001:db8:60:60::/64", "2001:db8:0:6::2"),
    ("2001:db8:70:70::/64", "2001:db8:0:7::2"),
    ("2001:db8:80:80::/64", "2001:db8:0:8::2"),
]

for prefix, nh in ipv6_cases:
    cmd = f"ipv6 route {prefix} {nh}"
    add_single(
        question=f"Which command creates an IPv6 static route to {prefix} via {nh}?",
        correct=cmd,
        distractors=[f"ip route {prefix} {nh}", f"ipv6 route {nh} {prefix}", f"ipv6 static-route {prefix} {nh}"],
        explanation=(
            "IPv6 static route syntax is 'ipv6 route <prefix> <next-hop|interface>'. "
            f"The correct form here is: {cmd}."
        ),
    )


# ---------------------------------------------------------------------------
# 3) OSPFv2/v3 single-area concepts and troubleshooting (40)
# ---------------------------------------------------------------------------
ospf_items = [
    ("In CCNA single-area OSPF, what area is used?", "Area 0", ["Area 1", "Area 255", "Any area without backbone"], "Single-area OSPF uses area 0, the backbone area, for all participating links."),
    ("Which command starts OSPFv2 process 10?", "router ospf 10", ["ospf process 10", "ip ospf 10", "router ospfv2 10"], "IOS enters OSPFv2 process mode with 'router ospf <process-id>'."),
    ("OSPF process ID must match between neighbors.", "False: process ID is locally significant", ["True: process ID must match exactly", "Only on DR links it must match", "Only in area 0 it must match"], "Process ID is local to each router. Area, timers, auth, and network parameters determine adjacency."),
    ("OSPF router ID selection without manual RID uses:", "Highest loopback IP, else highest active physical IP", ["Lowest interface IP", "First configured interface", "Neighbor's highest router ID"], "RID order is configured router-id first, then highest loopback, then highest physical interface IP."),
    ("After changing OSPF router-id, what is typically needed to apply it now?", "Restart OSPF process", ["Reload switchports", "Clear ARP only", "Change VLAN native ID"], "Router ID is chosen when the process starts, so you must restart the process (or reboot) to apply new RID immediately."),
    ("Wildcard for mask 255.255.255.0 is:", "0.0.0.255", ["255.255.255.0", "0.0.255.255", "0.0.0.0"], "Wildcard is inverse mask. Inverting 255.255.255.0 gives 0.0.0.255."),
    ("What does passive-interface do in OSPF?", "Advertises subnet but sends no hellos on that interface", ["Removes subnet from OSPF", "Shuts the interface", "Sets cost to infinite"], "Passive interface stops neighbor formation on that segment while keeping connected network advertisement."),
    ("Default OSPF network type on Ethernet is:", "Broadcast", ["Point-to-point", "NBMA-only", "Loopback"], "Ethernet defaults to broadcast network type, which uses DR/BDR election."),
    ("On point-to-point OSPF links:", "No DR/BDR election occurs", ["Both routers become DR", "Only BDR exists", "Election happens each hello"], "Point-to-point links form full adjacency directly and do not use DR/BDR roles."),
    ("Which OSPF timers must match for adjacency?", "Hello and Dead", ["SPF and LSA age", "ARP and MAC aging", "DHCP T1/T2"], "Hello packet checks include hello and dead intervals; mismatch prevents adjacency."),
    ("Persistent EXSTART in OSPF usually suggests:", "MTU mismatch", ["Process ID mismatch", "Hostname mismatch", "VLAN 1 shutdown"], "EXSTART/EXCHANGE stuck states commonly indicate MTU mismatch during database description exchange."),
    ("Route code 'O' in show ip route means:", "OSPF intra-area route", ["OSPF external only", "Static redistributed route", "IPv6 OSPFv3 route"], "In IPv4 routing table, O means OSPF intra-area route."),
    ("Best command to verify OSPF neighbors and state:", "show ip ospf neighbor", ["show ip protocols", "show ip ospf process", "show cdp neighbors"], "Neighbor table directly shows FULL/2WAY/EXSTART and peer IDs."),
    ("On broadcast segment, 2WAY between two DROTHER routers is:", "Normal behavior", ["Always an error", "Area mismatch symptom", "Authentication failure proof"], "DROTHER routers form FULL with DR/BDR, often staying 2WAY with each other."),
    ("OSPF interface cost is derived from:", "Reference bandwidth / interface bandwidth", ["Current utilization", "MTU only", "Dead timer"], "Default OSPF metric uses the bandwidth-based cost formula."),
    ("Why keep reference bandwidth consistent across routers?", "To keep path cost calculations comparable network-wide", ["To sync process IDs", "To disable DR election", "To force ECMP"], "Different reference values create inconsistent cost math and unpredictable path preference."),
    ("Command to inject default route into OSPF (when present):", "default-information originate", ["area 0 default-route", "ip ospf default-gateway", "redistribute static always"], "This command advertises 0.0.0.0/0 into OSPF from an ASBR when default exists."),
    ("Area mismatch between two OSPF interfaces on same link causes:", "No adjacency", ["Adjacency FULL but no routes", "2WAY-only always", "Automatic area correction"], "Area ID must match in hello checks; mismatch prevents neighbor formation."),
    ("Interface-level OSPFv2 enable command:", "ip ospf 10 area 0", ["router ospf 10 area 0", "ospf enable 10 0", "ip area ospf 0 10"], "Modern IOS supports per-interface OSPFv2 assignment with process and area."),
    ("DR election on broadcast uses first:", "Highest OSPF interface priority", ["Lowest router ID", "Highest process ID", "Lowest metric"], "Election checks priority first; router ID is only tie-breaker."),
    ("OSPF priority 0 means:", "Router cannot become DR/BDR on that segment", ["Router becomes DR always", "Adjacency disabled completely", "Area forced to 0"], "Priority 0 makes router ineligible for DR/BDR but still able to form adjacency."),
    ("Command showing area/timers/cost per OSPF interface:", "show ip ospf interface", ["show ip route ospf", "show ip protocols", "show interface counters"], "This command is the per-interface OSPF troubleshooting staple."),
    ("Common OSPFv3 area assignment style:", "Configured on interface", ["Only via IPv4 network statements", "In VLAN database mode", "Through static route command"], "OSPFv3 is interface-centric on IOS/XE."),
    ("Global command required for IPv6 forwarding with OSPFv3:", "ipv6 unicast-routing", ["ip routing", "ipv6 cef disable", "router ospfv3 enable"], "Without ipv6 unicast-routing, IPv6 control-plane may exist but forwarding is disabled."),
    ("Why OSPFv3 next-hop often appears as FE80::?", "OSPFv3 adjacencies use link-local addressing", ["Global next-hop is prohibited", "Route is inactive", "Only default uses FE80"], "IPv6 routing protocols commonly exchange hellos over link-local addresses."),
    ("Command entering OSPFv3 process mode (IOS XE style):", "router ospfv3 10", ["router ospf3 10", "ipv6 router ospf 10", "ospfv3 process 10 start"], "This is the typical process-level entry point on IOS XE platforms."),
    ("If OSPF configured but no learned routes appear, first check:", "Neighbor adjacency state", ["STP root", "DHCP pool", "MAC table size"], "Route exchange depends on adjacency/LSDB sync. Verify neighbor state before deeper checks."),
    ("Authentication mismatch on OSPF neighbors leads to:", "Adjacency failure", ["FULL but hidden routes", "Automatic fallback to clear-text", "DR-only adjacency"], "Auth type/key mismatch fails hello validation."),
    ("How can you influence OSPF path choice?", "Tune interface cost or bandwidth/reference settings", ["Change hostname", "Disable CDP", "Change console speed"], "OSPF selects lowest cumulative cost. Cost parameters are the intended tuning levers."),
    ("Command giving high-level OSPF running status and advertised networks:", "show ip protocols", ["show ip ospf database", "show vlan brief", "show interface switchport"], "show ip protocols summarizes dynamic routing process behavior and configured networks."),
    ("OSPF-enabled interface administratively down means:", "No adjacency on that link", ["Adjacency remains FULL", "Loopback takes over automatically", "OSPF ignores interface state"], "OSPF hellos cannot be sent/received when interface is down."),
    ("SPF in OSPF refers to:", "Shortest Path First algorithm run on LSDB", ["Hello timer", "Loop prevention at Layer 2", "Static failover feature"], "OSPF computes best paths with Dijkstra SPF using link-state topology."),
    ("Most direct per-interface mismatch command:", "show ip ospf interface <interface>", ["show startup-config", "show users", "show arp"], "This view exposes area, auth, timers, network type and state on one interface."),
    ("Which command confirms route code and next-hop for a default route?", "show ip route 0.0.0.0", ["show interface status", "show cdp neighbors detail", "show spanning-tree"], "Querying exact prefix 0.0.0.0 reveals active default route source and next-hop."),
]

for q, c, d, e in ospf_items:
    add_single(q, c, d, e)


# ---------------------------------------------------------------------------
# 4) Multi-answer (10)
# ---------------------------------------------------------------------------
multi_items = [
    (
        "Which two mismatches commonly prevent OSPF neighbors from reaching FULL state? (Choose two.)",
        ["Area ID mismatch", "Hello/Dead timer mismatch"],
        ["Different process IDs", "Different hostnames", "Different NTP servers"],
        "Area and hello/dead values are mandatory hello checks. Process ID and hostname are local attributes and do not need to match.",
    ),
    (
        "Which two commands are best to validate OSPF adjacency and learned routes? (Choose two.)",
        ["show ip ospf neighbor", "show ip route ospf"],
        ["show spanning-tree", "show interface status", "show vlan id 1"],
        "One command verifies neighbor state, the other verifies OSPF routes in RIB. Together they confirm control-plane and route installation.",
    ),
    (
        "On broadcast segments, which two factors determine DR election order? (Choose two.)",
        ["Interface OSPF priority", "Router ID tie-breaker"],
        ["Process ID", "Area ID", "Interface duplex"],
        "DR/BDR election checks highest priority first, then highest router ID if priorities tie.",
    ),
    (
        "Which two actions legitimately influence OSPF path selection? (Choose two.)",
        ["Set explicit OSPF interface cost", "Adjust reference bandwidth consistently"],
        ["Change hostname", "Disable CDP", "Change console line speed"],
        "OSPF path choice is metric-based. Cost and reference bandwidth tuning are valid metric controls.",
    ),
    (
        "For OSPFv3 adjacency troubleshooting, which two checks are highest priority? (Choose two.)",
        ["Same OSPF area on both interfaces", "ipv6 unicast-routing enabled globally"],
        ["VTP domain match", "Trunk native VLAN", "DHCP helper set"],
        "OSPFv3 requires IPv6 routing enabled and matching OSPF interface area configuration.",
    ),
    (
        "Which two statements are true about floating static routes? (Choose two.)",
        ["They use higher AD than primary route", "They install only when better route disappears"],
        ["They always use AD 1", "They require OSPF disabled", "They must point to Null0"],
        "Floating static is designed as backup by raising AD so primary dynamic/static route remains preferred.",
    ),
    (
        "Dual-ISP branch failover with static routing is best achieved by which two configs? (Choose two.)",
        ["Primary default route with lower AD", "Secondary default route with higher AD"],
        ["Both defaults same AD", "Only one default plus PortFast", "Change duplex toward ISP2"],
        "Different AD values enforce deterministic primary/backup behavior without protocol complexity.",
    ),
    (
        "Which two observations suggest missing return route in a routed network? (Choose two.)",
        ["Initiator reaches remote host but remote cannot initiate back", "Ping works one direction only"],
        ["Both directions fail due to VLAN mismatch", "STP flapping logs appear", "Neighbor table shows FULL on all links"],
        "One-way reachability is classic reverse-path issue. Add route back toward source subnet.",
    ),
    (
        "Which two IOS commands are directly useful to validate static route configuration and installation? (Choose two.)",
        ["show running-config | include ^ip route", "show ip route static"],
        ["show spanning-tree summary", "show vlan brief", "show clock detail"],
        "One confirms the configured line, the other confirms RIB installation and next-hop status.",
    ),
    (
        "Which two statements correctly describe longest-prefix match? (Choose two.)",
        ["A /32 host route beats a /24 route", "A default route is used only if no longer prefix matches"],
        ["Administrative distance is checked before prefix length", "RIP routes always beat static routes", "Only dynamic routes use prefix comparison"],
        "Prefix specificity is evaluated first; AD and metric comparisons occur among routes with the same prefix length.",
    ),
]

for q, c, d, e in multi_items:
    add_multi(q, c, d, e)


# ---------------------------------------------------------------------------
# 5) Final fill scenarios (10) -> total exactly 100
# ---------------------------------------------------------------------------
final_items = [
    (
        "If OSPF route to 10.10.10.0/24 disappears and floating static AD 150 exists, what should occur next?",
        "Floating static route becomes active in RIB",
        ["No route can replace OSPF", "Router reload required", "Only connected routes can replace dynamic"],
        "When primary route is withdrawn, next best valid route (higher AD floating static) is installed automatically.",
    ),
    (
        "Which command confirms current OSPF router ID in use?",
        "show ip ospf | include Router ID",
        ["show version | include Router ID", "show interfaces | include Router ID", "show run | include hostname"],
        "Process output includes active router ID, which is critical when troubleshooting adjacency and DR election behavior.",
    ),
    (
        "For destination 2001:db8:100:10::1, which route is most specific?",
        "2001:db8:100:10::/64",
        ["2001:db8:100::/48", "2001:db8::/32", "::/0"],
        "Longest-prefix logic applies equally in IPv6. /64 is more specific than /48, /32, or default.",
    ),
    (
        "A static route is configured but missing from table. Most likely reason?",
        "Next-hop or outgoing interface is currently unreachable",
        ["Clock not synchronized", "No loopback configured", "Hostname too long"],
        "IOS installs static route only if forwarding path can be resolved. Broken next-hop connectivity prevents installation.",
    ),
    (
        "What does FULL/DR in show ip ospf neighbor mean?",
        "Adjacency is fully synchronized with neighbor that is DR on that segment",
        ["OSPF disabled on interface", "Neighbor unreachable at Layer 2", "Local router is always BDR"],
        "FULL means LSDB sync complete. DR indicates that neighbor's role on broadcast network.",
    ),
    (
        "Which OSPF attribute is configured per-interface and often differs by link design?",
        "OSPF network type",
        ["Administrative distance", "Process ID requirement", "Router ID source order"],
        "Network type (broadcast, point-to-point, etc.) is interface-specific and affects adjacency behavior.",
    ),
    (
        "Which command removes IPv6 static route to 2001:db8:99::/64 via 2001:db8:1::2?",
        "no ipv6 route 2001:db8:99::/64 2001:db8:1::2",
        ["clear ipv6 route 2001:db8:99::/64 2001:db8:1::2", "delete ipv6 route 2001:db8:99::/64 2001:db8:1::2", "undo ipv6 route 2001:db8:99::/64 2001:db8:1::2"],
        "Use the exact configured line prefixed with 'no' to remove IPv6 static route entries from running config.",
    ),
    (
        "If OSPFv3 neighbors are up but IPv6 packets are not forwarded, which global setting is often missing?",
        "ipv6 unicast-routing",
        ["ip routing", "spanning-tree mode rapid-pvst", "service password-encryption"],
        "Control-plane can appear healthy while forwarding is off. IPv6 forwarding requires global ipv6 unicast-routing.",
    ),
    (
        "Which command verifies static IPv6 and dynamic IPv6 entries in one view?",
        "show ipv6 route",
        ["show ipv6 static", "show ip route ipv6", "show protocols ipv6"],
        "show ipv6 route is the main IPv6 RIB view and includes static, connected, and protocol-learned entries.",
    ),
    (
        "If no specific route and no default route exist, router behavior is:",
        "Drop packet and usually send ICMP destination unreachable",
        ["Flood packet to all interfaces", "Forward to highest RID neighbor", "Send to loopback automatically"],
        "Forwarding requires a matching route. Without one, packet is dropped and unreachable may be generated.",
    ),
]

final_items = final_items[:4]

for q, c, d, e in final_items:
    add_single(q, c, d, e)


if len(questions) != 100:
    raise RuntimeError(f"Expected 100 questions, got {len(questions)}")

for i, q in enumerate(questions, 1):
    if len(q["options"]) < 4:
        raise RuntimeError(f"Q{i} has <4 options")
    if not q["correct_answers"]:
        raise RuntimeError(f"Q{i} has no answers")
    if any(a < 0 or a >= len(q["options"]) for a in q["correct_answers"]):
        raise RuntimeError(f"Q{i} answer index out of range")
    if not q["explanation"].strip():
        raise RuntimeError(f"Q{i} explanation missing")

stats = {
    "single": sum(1 for q in questions if len(q["correct_answers"]) == 1),
    "multi": sum(1 for q in questions if len(q["correct_answers"]) > 1),
    "opt4": sum(1 for q in questions if len(q["options"]) == 4),
    "opt5": sum(1 for q in questions if len(q["options"]) == 5),
    "opt6": sum(1 for q in questions if len(q["options"]) == 6),
}

payload = {"count": len(questions), "stats": stats, "questions": questions}
out_file = "tmp/scripts/ccna_ip_connectivity_100_explained.json"
with open(out_file, "w", encoding="utf-8") as f:
    json.dump(payload, f, ensure_ascii=False, indent=2)

print(f"generated={payload['count']} single={stats['single']} multi={stats['multi']} opt4={stats['opt4']} opt5={stats['opt5']} opt6={stats['opt6']}")
print(f"output={out_file}")
