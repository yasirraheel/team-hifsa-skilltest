import json
import random
from pathlib import Path

random.seed(77)
base = Path(r"c:/xampp/htdocs/team-hifsa-skilset/tmp/scripts")

nf = json.loads((base / "ccna_network_fundamentals_100.json").read_text(encoding="utf-8"))["questions"]
na = json.loads((base / "ccna_network_access_100.json").read_text(encoding="utf-8"))["questions"]

nf_multi = [
    {
        "question": "A campus team is designing IPv4 addressing for growth and route summarization. Which two actions directly support efficient address utilization? (Select TWO answers.)",
        "options": [
            "Use VLSM to size subnets by host need",
            "Use a single /16 for every VLAN",
            "Summarize contiguous networks at distribution",
            "Disable subnetting and use classful boundaries",
            "Assign APIPA addresses for all static servers",
        ],
        "correct_answers": [0, 2],
    },
    {
        "question": "A help desk receives complaints that hosts cannot reach remote networks but can reach local peers. Which two checks are most relevant first? (Select TWO answers.)",
        "options": [
            "Verify default gateway configuration on hosts",
            "Verify host DNS suffix",
            "Verify subnet mask correctness",
            "Verify monitor brightness settings",
            "Verify keyboard layout",
        ],
        "correct_answers": [0, 2],
    },
    {
        "question": "An engineer validates IPv6 behavior on a LAN. Which two statements are correct about link-local addresses? (Select TWO answers.)",
        "options": [
            "They are used for on-link communication",
            "They are routable on the public Internet",
            "They typically begin with FE80::/10",
            "They replace default gateways",
            "They require DHCPv4",
        ],
        "correct_answers": [0, 2],
    },
    {
        "question": "A branch migration enables SLAAC. Which two components are required for hosts to auto-configure addresses and gateway info? (Select TWO answers.)",
        "options": [
            "Router Advertisements",
            "Neighbor Discovery",
            "ARP replies",
            "VTP advertisements",
            "PAgP negotiation",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A network analyst is troubleshooting excessive broadcast traffic in a flat Layer 2 segment. Which two design choices reduce broadcast scope? (Select TWO answers.)",
        "options": [
            "Introduce Layer 3 boundaries",
            "Segment users with VLANs",
            "Increase collision domain size",
            "Disable IP addressing",
            "Convert all links to hubs",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A design review asks for correct IPv4 private ranges. Which two are valid RFC1918 blocks? (Select TWO answers.)",
        "options": [
            "10.0.0.0/8",
            "172.16.0.0/12",
            "172.32.0.0/12",
            "192.0.2.0/24",
            "8.8.8.0/24",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A security architect evaluates transport behavior. Which two protocols are connection-oriented by design? (Select TWO answers.)",
        "options": [
            "TCP",
            "UDP",
            "QUIC over UDP",
            "SCTP",
            "ICMP",
        ],
        "correct_answers": [0, 3],
    },
    {
        "question": "A remote office needs addressing for exactly 120 hosts per VLAN with minimal waste. Which two prefixes satisfy the requirement? (Select TWO answers.)",
        "options": [
            "/25",
            "/24",
            "/26",
            "/27",
            "/30",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "You are documenting IPv6 scopes. Which two address types are not intended for global Internet routing in normal enterprise design? (Select TWO answers.)",
        "options": [
            "Link-local",
            "Unique local",
            "Global unicast",
            "Global anycast",
            "Provider-assigned /48",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A troubleshooting checklist asks for likely signs of subnet mask mismatch on hosts. Which two are common symptoms? (Select TWO answers.)",
        "options": [
            "Can reach some local devices but not others in same expected subnet",
            "Cannot resolve DNS hostname format",
            "Sends traffic for local peers to default gateway",
            "Switch loses startup-config",
            "Link LEDs stop blinking permanently",
        ],
        "correct_answers": [0, 2],
    },
]

na_multi = [
    {
        "question": "A user VLAN is moved to a new switch. Which two interface commands are required on an access port for VLAN assignment? (Select TWO answers.)",
        "options": [
            "switchport mode access",
            "switchport access vlan <id>",
            "switchport trunk encapsulation dot1q",
            "ip routing",
            "spanning-tree mode rapid-pvst",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A trunk between distribution switches fails to pass expected VLAN traffic. Which two checks are highest priority? (Select TWO answers.)",
        "options": [
            "Allowed VLAN list on both ends",
            "Native VLAN consistency on both ends",
            "Console line password",
            "Router loopback status",
            "NTP stratum",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A campus experiences intermittent Layer 2 loops from unmanaged edge devices. Which two protections are best at access ports? (Select TWO answers.)",
        "options": [
            "PortFast",
            "BPDU Guard",
            "Disable CDP globally",
            "Increase STP hello to 30s",
            "Enable VTP server on all access switches",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "An STP root bridge election review is underway. Which two values influence bridge ID selection? (Select TWO answers.)",
        "options": [
            "Bridge priority",
            "Switch MAC address",
            "ARP timeout",
            "Interface duplex",
            "Native VLAN",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A wireless deployment in a busy office has high co-channel contention. Which two changes commonly help? (Select TWO answers.)",
        "options": [
            "Reduce channel width in dense areas",
            "Tune AP transmit power based on survey",
            "Disable 5 GHz radios",
            "Set all APs to maximum power",
            "Force every SSID to open authentication",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A network engineer configures EtherChannel with LACP. Which two mode pairings can form a channel? (Select TWO answers.)",
        "options": [
            "active-active",
            "active-passive",
            "passive-passive",
            "auto-auto",
            "desirable-auto",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A branch uses controller-based WLAN. Which two statements are correct for CAPWAP operation? (Select TWO answers.)",
        "options": [
            "APs establish control connectivity to the WLC",
            "Data/control can traverse CAPWAP tunnels depending on mode",
            "CAPWAP replaces DHCP",
            "CAPWAP disables roaming",
            "CAPWAP requires STP root on AP",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "For secure access edge design, which two controls reduce unauthorized endpoint access most directly? (Select TWO answers.)",
        "options": [
            "Port security",
            "Disable and isolate unused ports",
            "Enable dynamic desirable on user ports",
            "Set native VLAN to production user VLAN",
            "Disable all logging",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "A voice deployment needs segmentation and QoS consistency. Which two switchport features are commonly used at the edge? (Select TWO answers.)",
        "options": [
            "Access VLAN for data",
            "Voice VLAN for IP phones",
            "SVI shutdown",
            "BPDU filter global",
            "Trunk all user ports",
        ],
        "correct_answers": [0, 1],
    },
    {
        "question": "An operations team validates trunk hardening. Which two actions are security best practices? (Select TWO answers.)",
        "options": [
            "Prune unused VLANs from trunks",
            "Set explicit native VLAN and avoid VLAN 1 for user data",
            "Allow all VLANs by default",
            "Enable DTP dynamic desirable everywhere",
            "Disable STP on trunk links",
        ],
        "correct_answers": [0, 1],
    },
]


def to_single(item):
    opts = item["options"]
    ca = int(item.get("correct_answer", 0))
    q = item["question"].strip()
    if "Select" not in q:
        q = q + " (Select the best answer.)"
    return {
        "question": q,
        "options": opts,
        "correct_answers": [ca],
        "mark": 1,
    }


def build_bank(base_items, multi_items):
    used = set()
    out = []

    for q in multi_items:
        options = q["options"]
        if not (4 <= len(options) <= 6):
            continue
        if q["question"] in used:
            continue
        used.add(q["question"])
        out.append({
            "question": q["question"],
            "options": options,
            "correct_answers": sorted(q["correct_answers"]),
            "mark": 1,
        })

    for item in base_items:
        s = to_single(item)
        if s["question"] in used:
            continue
        if not (4 <= len(s["options"]) <= 6):
            continue
        used.add(s["question"])
        out.append(s)
        if len(out) == 100:
            break

    if len(out) < 100:
        raise RuntimeError(f"bank size too small: {len(out)}")

    random.shuffle(out)
    out = out[:100]

    counts = {"single": 0, "multi": 0, "opt4": 0, "opt5": 0, "opt6": 0}
    for q in out:
        if len(q["correct_answers"]) > 1:
            counts["multi"] += 1
        else:
            counts["single"] += 1
        counts[f"opt{len(q['options'])}"] += 1

    return {"count": len(out), "stats": counts, "questions": out}

nf_bank = build_bank(nf, nf_multi)
na_bank = build_bank(na, na_multi)

(base / "ccna_network_fundamentals_100_mixed.json").write_text(json.dumps(nf_bank, indent=2), encoding="utf-8")
(base / "ccna_network_access_100_mixed.json").write_text(json.dumps(na_bank, indent=2), encoding="utf-8")

print("nf", nf_bank["stats"])
print("na", na_bank["stats"])
