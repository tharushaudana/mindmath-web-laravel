<div>
    @php
        $answers = json_decode($question->answers, true);
        $studentAnswer = $question->studentAnswer();

        $motivationalTexts = array(
            "You've got this!",
            "Keep trying!",
            "Don't give up!",
            "Stay strong!",
            "Keep moving!",
            "You can do it!",
            "Stay determined!",
            "You're capable!",
            "Believe in yourself!",
            "Persist!",
            "Stay focused!",
            "Never quit!",
            "Keep on!",
            "Stay positive!",
            "Rise above!",
            "Stay resilient!",
            "Keep going strong!",
            "Don't stop now!",
            "Stay committed!",
            "You've got potential!",
            "Keep the faith!"
        );

        $motivationalText = $motivationalTexts[mt_rand(0, count($motivationalTexts) - 1)];
    @endphp

    <div id="answers-container" style="display: {{ $question->isExpired($test->config->dur_per) ? 'none' : 'block' }};">
        @foreach ($answers as $i => $answer)
        <div wire:click.prevent="saveAnswer({{ $i }})" class="w-100 px-4 rounded-4 mb-2 ans-card" style="background-color: {{ !is_null($studentAnswer) && $studentAnswer->answer == $i ? '#8BE8E5' : '#EDE4FF' }}; color: #6F61C0; font-weight: bold; position: relative; cursor: pointer;">
            {{ $answer }}
            <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
        </div>                        
        @endforeach
    </div>

    <div id="expired-container" style="display: {{ $question->isExpired($test->config->dur_per) ? 'block' : 'none' }};">
        <p class="text-success" align="center" style="opacity: 0.5; font-size: 60px;"><i class="fa-regular fa-thumbs-up"></i></p>
        @if (!is_null($studentAnswer))
        <h4 class="text-success" style="font-weight: bold;" align="center">Good Job!</h4>
        @else
        <h4 class="text-success" style="font-weight: bold;" align="center">{{ $motivationalText }}</h4>
        @endif
        <p class="text-success" style="font-size: 12px;" align="center">Click on the <b>Next</b> button.</p>
    </div>

    @push('scripts')
    <script>
        var qMillis = {{ $question->timeLeft($test->config->dur_per) }} * 1000;

        const qInterval = setInterval(() => {
            qMillis -= 10;

            if (qMillis == 0) {
                $('#answers-container').hide();
                $('#expired-container').show();
                clearInterval(qInterval);
            }
        }, 10);
    </script>
    @endpush
</div>
