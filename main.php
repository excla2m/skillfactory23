<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];


function getFullNameFromParts($surname, $name, $patronomyc)
{
    $fullName =  "$surname $name $patronomyc";
    return $fullName;
}

function getPartsFromFullname($fullName)
{
    $myArr = explode(' ', $fullName);
    return ['surname' => $myArr[0], 'name' => $myArr[1], 'patronomyc' => $myArr[2]];

}

function getShortName($fullName)
{
    $myArrName = getPartsFromFullname($fullName);
    $name = $myArrName['name'];
    $surname = $myArrName['surname'];
    $shortSurname = substr($surname, 0, 1);
    return"$name $shortSurname.";

}

function EndsOfSournames($line, $symbolsToCheck)
{
    $lineLength = strlen($line);
    $symbolsCount = strlen($symbolsToCheck);
    $lastSymbols = substr($line, $lineLength - $symbolsCount, $symbolsCount);
    if($lastSymbols === $symbolsToCheck)
    {
    return true;
    }
    return false;
}



function getGenderFromName($fullname)
{
    $arrName = getPartsFromFullname($fullname);

    $surname = $arrName['surname'];
    $name = $arrName['name'];
    $patronomyc = $arrName['patronomyc'];

    $femaleCount = 0;
    $maleCount = 0;
    
    if(EndsOfSournames($patronomyc, 'вна'))
    {
    $femaleCount++;
    }
    if(EndsOfSournames($name, 'а'))
    {
    $femaleCount++;
    }

    if(EndsOfSournames($patronomyc, 'ич'))
    {
    $maleCount++;
    }

    if(EndsOfSournames($surname, 'ва'))
    {
    $femaleCount++;
    }

    if(EndsOfSournames($name, 'й') || EndsOfSournames($name, 'н'))
    {
    $maleCount++;
    }
    if(EndsOfSournames($surname, 'в'))
    {
        $maleCount++;
    }
    return  $maleCount <=> $femaleCount;
}

function getGenderDescription($persons_array)
{
    $count = count($persons_array);

    $males = 0;
    $females = 0;
    $unknown = 0;

    foreach($persons_array as $key => $user)
    {
        $fullName = $user['fullname'];
        $gender = getGenderFromName($fullName);
        if($gender == 1)
        {
            $males++;
        }
        else if($gender == -1)
        {
            $females++;
        }
        else
        {
            $unknown++;
        }
    }

    $malePercent = round(($males / $count) * 100, 1);
    $femalePercent = round(($females / $count) * 100, 1);
    $percentOfUnknown = 100 - $malePercent - $femalePercent;
    
        echo <<<HEREDOCLETTER
Гендерный состав аудитории:
---------------------------
Мужчины - {$malePercent}%
Женщины - {$femalePercent}%
Не удалось определить - {$percentOfUnknown}%
HEREDOCLETTER;
}