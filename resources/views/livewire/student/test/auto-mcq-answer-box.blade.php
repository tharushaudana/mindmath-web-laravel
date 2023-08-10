<div>
    @php
        $answers = json_decode($question->answers, true);
        $studentAnswer = $question->studentAnswer();
    @endphp

    @foreach ($answers as $i => $answer)
    <div wire:click.prevent="saveAnswer({{ $i }})" class="w-100 px-4 rounded-4 mb-2 ans-card" style="background-color: {{ !is_null($studentAnswer) && $studentAnswer->answer == $i ? '#8BE8E5' : '#EDE4FF' }}; color: #6F61C0; font-weight: bold; position: relative; cursor: pointer;">
        {{ $answer }}
        <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
    </div>                        
    @endforeach
</div>
