import json
from pathlib import Path

base = Path(r"c:/xampp/htdocs/team-hifsa-skilset/tmp/scripts")


def with_explanations(src_file: str, out_file: str):
    payload = json.loads((base / src_file).read_text(encoding="utf-8"))
    questions = payload.get("questions", [])

    for q in questions:
        options = q.get("options", [])
        correct_idx = [int(i) for i in q.get("correct_answers", [])]
        correct_texts = [options[i] for i in correct_idx if 0 <= i < len(options)]

        if not correct_texts:
            q["explanation"] = "The correct option is based on standard CCNA domain concepts and protocol behavior."
            continue

        if len(correct_texts) == 1:
            q["explanation"] = (
                f"Correct answer: {correct_texts[0]}. "
                "This is correct based on CCNA principles for this topic; the other options conflict with expected protocol or design behavior."
            )
        else:
            joined = ", ".join(correct_texts)
            q["explanation"] = (
                f"Correct answers: {joined}. "
                "These choices align with CCNA best-practice behavior for the scenario, while the remaining options are distractors."
            )

    payload["questions"] = questions
    (base / out_file).write_text(json.dumps(payload, indent=2), encoding="utf-8")
    print(f"{out_file}: {len(questions)} questions")


with_explanations("ccna_network_fundamentals_100_mixed.json", "ccna_network_fundamentals_100_mixed_explained.json")
with_explanations("ccna_network_access_100_mixed.json", "ccna_network_access_100_mixed_explained.json")
