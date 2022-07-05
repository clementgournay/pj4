class Rule {
    text = '';
    condition;
    result;

    constructor(text) {
        this.text = text;
        var parts = this.text.split('+then+');
        var conditionText = parts[0].replace('if+', '');
        var resultText = parts[1];
        this.condition = new Phrase(conditionText);
        this.result = new Phrase(resultText);
    }
}

class Phrase {
    text = '';
    parts = [];
    subject = '';
    property = '';
    operand = '';
    value = '';

    constructor(text) {
        this.text = text;
        this.parse();
    }

    parse() {
        this.parts = this.text.split('+');
        this.subject = this.parts[0];
        this.property = this.parts[1];
        this.operand = this.parts[2];
        this.value = this.parts[3];
    }
}

function SubjectFitPhrase(subject, phrase) {
    let fitPhrase = false;
    switch(phrase.operand) {
        case 'is':
            fitPhrase = subject[phrase.property] == phrase.value;
            break;
        case 'not':
            fitPhrase = subject[phrase.property] != phrase.value;
            break;
    }
    return fitPhrase;
}

function findRuleBySubject(rules, subject) {
    var i = 0; var found = false;
    while (!found && i < rules.length) {
        if (rules[i].subject === subject) found = true;
        else i++;
    }
    return (found) ? i : -1;
}
