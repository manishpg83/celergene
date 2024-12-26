@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        .tab-border {
            padding: 25px 0px 25px;
            border-left: 1px solid gray;
            border-right: 1px solid gray;
        }

        .clinicalstudies-bg {
            background-position: center;
            width: 100%;
            background-repeat: repeat;
            padding-top: 150px;
            padding-bottom: 50px;
            background: linear-gradient(to bottom, rgba(15, 16, 49, 0) 0%, rgba(15, 16, 49, 1.75) 100%);
        }

        .tab-box {
            padding: 40px 50px 50px;
            box-shadow: 0px 0px 10px rgba(68, 68, 68, 0.6);
            margin: -50px auto 70px auto;
        }

        button:hover {
            color: #868686 !important;
        }

        .Opensan-Sanserif {
            font-family: 'Open Sans', sans-serif;
        }


        @media (max-width: 768px) {
            .tab-box {
                padding: 40px 30px 50px !important;
                box-shadow: none !important;
                margin: 0px auto 70px auto;
            }

            .clinicalstudies-bg {
                padding-bottom: 20px !important;
            }
        }
    </style>

    <section class="margin-top">
        <div class="px-0">
            <div class="container-fluid col-lg-10 col-xxl-11 px-4 px-lg-2">
                <ul class="nav nav-tabs nav-justified flex-column flex-lg-row px-2 px-lg-1" id="myTab" role="tablist">
                    <li class="nav-item tab tab-border" role="presentation">
                        <button class="nav-link text-grey border-0 active" id="bio-dna-tab" data-bs-toggle="tab"
                            data-bs-target="#bio-dna-tab-pane" type="button" role="tab"
                            aria-controls="bio-dna-tab-pane" aria-selected="true">BIO-DNA CELLULAR COMPLEX</button>
                    </li>
                    <li class="nav-item tab tab-border" role="presentation">
                        <button class="nav-link text-grey border-0" id="peptide-tab" data-bs-toggle="tab"
                            data-bs-target="#peptide-tab-pane" type="button" role="tab"
                            aria-controls="peptide-tab-pane" aria-selected="false" tabindex="-1">PEPTIDE E
                            COLLAGEN</button>
                    </li>
                    <li class="nav-item tab tab-border" role="presentation">
                        <button class="nav-link text-grey border-0" id="hydro-tab" data-bs-toggle="tab"
                            data-bs-target="#hydro-tab-pane" type="button" role="tab" aria-controls="hydro-tab-pane"
                            aria-selected="false" tabindex="-1">HYDRO MN PEPTIDE</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content Opensan-Sanserif" id="myTabContent">
                <div class="tab-pane active show" id="bio-dna-tab-pane" role="tabpanel" aria-labelledby="bio-dna-tab"
                    tabindex="0">
                    <div class="container-fluid clinicalstudies-bg"
                        style="background-image: linear-gradient(to bottom, rgba(15, 16, 49, 0) 0%, rgba(15, 16, 49, 1.75) 100%), url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/image-00.jpg');">
                        <div class="container">
                            <div class="col-lg-11 mx-auto float-none">
                                <p class="text-white mb-4">
                                    Bio-DNA Cellular Marine Complex, Celergen’s most potent ingredient, is an all-natural
                                    product obtained from marine species living <br>
                                    in pollution-free, deep ocean waters.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container padding-x">
                        <div class="tab-box bg-white">
                            <p class="text-blue">
                                Extensive clinical studies show that Bio-DNA Cellular Marine Complex provides the following
                                health benefits:
                            </p>
                            <p class="text-darkred pt-3">
                                I. MANAGEMENT OF OSTEOARTHRITIS PAIN
                            </p>
                            <p class="text-grey pt-3">
                                Bio-DNA Cellular Marine Complex is proven to manage osteoarthritis pain effectively and
                                naturally,
                                allowing you to live an active, pain-free lifestyle within weeks without painkillers or
                                surgery.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/I_MANAGEMENT-OF-OSTEOARTHRITIS-PAIN1.jpg"
                                    alt="" width="370px" height="386px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    This figure shows the effects of a combination of 400 mg/day of Bio-DNA Cellular Marine
                                    Complex and
                                    vitamin B+E complex given orally for 30 days on self-reported pain in 2,960
                                    osteoarthritis sufferers
                                    (average age 61).
                                </p>
                                <p class="text-grey pt-3">
                                    At the end of 30 days, more than 89.5% of volunteers reported substantially reduced pain
                                    relative
                                    to the start of the study.Overall, 21% experienced total relief, 68.5% felt partial
                                    relief,
                                    and nearly 84% reported a noticeable improvement in their physical performance.
                                </p>
                            </div>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/I_MANAGEMENT-OF-OSTEOARTHRITIS-PAIN2.jpg"
                                    alt="" width="450px" height="410px" class="float-end ms-4 mb-4">
                                <p class="text-grey pt-3">
                                    This figure shows the effects of 200 mg/day of Bio-DNA Cellular Marine Complex (Bio-DNA
                                    CMC) given orally
                                    for 21 days and 42 days on self-reported knee and hip pain associated with
                                    osteoarthritis in 67 invalids.
                                    The effects of Diclofenac, a painkilling non-steroidal anti-inflammatory drug (NSAID) is
                                    also provided
                                    for comparison.
                                </p>
                                <p class="text-grey pt-3">
                                    At 21 days, just under 15% of invalids treated with Bio-DNA CMC reported significantly
                                    less knee and hip
                                    pain, compared to just over 25% for Diclofenac . At 42 days, nearly 40% of invalids
                                    reported a
                                    significantreduction in their knee and hip pain with Bio-DNA CMC, relative to 35% with
                                    Diclofenac.
                                </p>
                                <p class="text-grey pt-3">
                                    In other words, Bio-DNA CMC is as or more effective than Diclofenac after 6 weeks of
                                    treatment in
                                    managing arthritis pain – without any of Diclofenac’s side effects.
                                </p>
                            </div>
                            <p class="text-darkred pt-3">
                                II. IMPROVEMENT IN STAMINA DURING EXERCISE AND RECUPERATION AFTER EXERCISE
                            </p>
                            <p class="text-grey pt-3">
                                Levels of cellular enzymes and other proteins critical for energy production drop with age.
                                Bio-DNA Cellular
                                Marine Complex boosts enzyme levels and activity, which dramatically affects energy and
                                stamina. Several male
                                patients claimed that they no longer felt the need to take Viagra because of a renewed sense
                                of vitality
                                across the board.
                            </p>
                            <p class="text-grey pt-3">
                                Clinical studies show that Bio-DNA Cellular Marine Complex boosts stamina as measured by
                                oxygen consumption during
                                exercise.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/II_IMPROVEMENT-IN-STAMINA1.jpg"
                                    alt="" width="359px" height="353px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    This figure shows the effect of Bio-DNA Cellular Marine Complex (Bio-DNA CMC) given
                                    orally for 21 days
                                    on stamina relative to placebo as measured by oxygen consumption during exercise.
                                </p>
                                <p class="text-grey pt-3">
                                    At the start of the study on Day 0, average oxygenconsumption in study participants was
                                    38.3 ml/MN/kg.
                                    After 21 days of Bio-DNA CMC treatment, average oxygen consumption increased to 39.6%.
                                </p>
                                <p class="text-grey pt-3">
                                    In other words, Bio-DNA CMC improves stamina as measured by oxygen consumption within 3
                                    weeks without
                                    any of the harmful side effects of steroids or other banned substances.
                                </p>
                                <p class="text-grey pt-3">
                                    In a related study, 80% of the study subjects showed an improvement in their
                                    recuperation after
                                    exercise.
                                </p>
                            </div>
                            <p class="text-darkred pt-3">
                                III. REDUCTION IN PHYSICAL SIGNS AND SYMPTOMS OF AGING
                            </p>
                            <p class="text-grey pt-3">
                                Bio-DNA Cellular Marine Complex gives your cells the nutrition they need to stimulate
                                cellular enzymes
                                critical for self-healing and energy production by triggering cellular rejuvenation in your
                                body.
                            </p>
                            <p class="text-grey pt-3">
                                Clinical studies show that Bio-DNA Cellular Marine Complex reduces many of the unpleasant
                                physical symptoms
                                of aging and enhances physical wellbeing.
                            </p>
                            <p class="text-grey pt-3">
                                This figure shows the effect of 800 mg/day of Bio-DNA Cellular Marine Complex given orally
                                for 15 days on
                                various physical symptoms of aging. Consumption of Bio-DNA Cellular Marine Complex led to
                                significant reductions in self-reported muscle pain (63%); vision problems (57%);
                                palpitations (46%); breathing difficulties (55%); flatulence (46%); dizziness and excessive
                                sweating (62.5%).
                            </p>
                            <p class="text-grey pt-3">
                                In other words, Bio-DNA Cellular Marine Complex significantly improves physical wellbeing by
                                reducing many
                                of the unpleasant physical symptoms associated with aging. In a related study, subjects
                                reported significant
                                fatigue reduction, both in the evening and after waking up in the morning.
                            </p>
                            <p class="text-darkred pt-3">
                                IV. POSITIVE EFFECTS ON MENTAL HEALTH
                            </p>
                            <p class="text-grey pt-3">
                                Bio-DNA Cellular Marine Complex is proven to have many positive effects on mental wellbeing,
                                improving overall quality
                                of life and restoring satisfaction in daily activities and social interactions.
                            </p>
                            <p class="text-grey pt-3">
                                Clinical studies show that daily intake of Bio-DNA Cellular Marine Complex significantly
                                improves mood and offers profound
                                relief from anxiety, sleep disturbances, memory lapses and depression.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/IV_POSITIVE-EFFECTS-ON-MENTAL-HEALTH.jpg"
                                    alt="" width="350px" height="364px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    This figure shows the effects of 800 mg/Day Bio-DNA Cellular Marine Complex on
                                    self-reported markers of
                                    mental health in 688 subjects (average age 44 years). After 15 days, subjects reported
                                    significant
                                    improvement in anxiety and apprehension (32%); mental fatigue (54%); irrational fears
                                    (54%); sleep
                                    disorders (47%); memory loss (45%); and sadness/depression (50%).
                                </p>
                                <p class="text-grey pt-3">
                                    In other words Bio-DNA Cellular Marine Complex is highly effective in improving various
                                    aspects of
                                    mental health after just 15 days without any of the toxic side effects of commercially
                                    available mental
                                    health drugs.
                                </p>
                            </div>
                            <p class="text-darkred pt-3">
                                V. SIGNIFICANT REDUCTION OF RADICAL DAMAGE
                            </p>
                            <p class="text-grey pt-3">
                                The free radical theory of aging explains that we age because our cells accumulate free
                                radical damage over
                                time. Most biologically relevant free radicals are highly reactive and cause oxidative
                                damage to cellular
                                structures such as DNA,leading to cancer and age-related diseases.
                            </p>
                            <p class="text-grey pt-3">
                                In a laboratory study, Bio-DNA Cellular Marine Complex inhibits lipid peroxidation,
                                suggesting that it is an
                                effective antioxidant that can postpone cellular aging by countering the harmful effects of
                                damaging free
                                radicals.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/V_POSTPONING-CELLULAR-AGING-BY-COUNTERING.jpg"
                                    alt="" width="350px" height="381px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    This figure shows the effect of Bio-DNA Cellular Marine Complex on lipid peroxidation in
                                    rat hepatocytes
                                    overloaded with iron.
                                </p>
                                <p class="text-grey pt-3">
                                    Treatment with a combination of vitamin E (250 mm) and Bio-DNA Cellular Marine Complex
                                    (1, 2 and 4 mg/mL)
                                    clearly offered stronger inhibition of lipid peroxidation and better protection against
                                    free radicals than
                                    either agent alone. In fact, combining vitamin E with 4 mg/mL Bio-DNA Cellular Marine
                                    Complex prevented
                                    lipid peroxidation by more than 90% in this study.
                                </p>
                                <p class="text-grey pt-3">
                                    Antioxidants limit oxidative damage to biological structures by free radicals –
                                    therefore, this study
                                    suggests Bio-DNA Cellular Marine Complex is an effective antioxidant that can slow down
                                    or even postpone
                                    cellular aging by countering the harmful effects of damaging free radicals.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="peptide-tab-pane" role="tabpanel" aria-labelledby="peptide-tab"
                    tabindex="0">
                    <div class="container-fluid clinicalstudies-bg"
                        style="background-image: linear-gradient(to bottom, rgba(15, 16, 49, 0) 0%, rgba(15, 16, 49, 1.75) 100%), url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/image-00.jpg');">
                        <div class="container">
                            <div class="col-lg-11 mx-auto float-none">
                                <p class="text-white mb-4">
                                    Peptide E Collagen – another of Celergen’s essential ingredients – rebuilds your skin
                                    from the inside out. It is easily absorbed <br>
                                    and acts directly on the skin, making it look healthier and radiant almost immediately.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container padding-x">
                        <div class="tab-box bg-white">
                            <p class="text-blue">
                                Extensive clinical studies show that Peptide E Collagen provides the following health
                                benefits:
                            </p>
                            <p class="text-darkred pt-3">
                                I. REDUCTION OF LINES AND WRINKLES
                            </p>
                            <p class="text-grey pt-3">
                                Made up of the 2 main components of outer skin layers, collagen and elastin, Peptide E
                                Collagen is easily
                                absorbed, can lift and tone slack areas, improve hydration and skin thickness, and reduce
                                lines, wrinkles,
                                and roughness.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/I_REDUCTION-OF-LINES-AND-WRINKLES.jpg"
                                    alt="" width="389px" height="329px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    This figure shows the effect of 2 grams/day of Peptide E Collagen given orally for 28
                                    days on forearm
                                    wrinkles and crow’s feet in 43 healthy female volunteers, aged 40-55 years.
                                </p>
                                <p class="text-grey pt-3">
                                    At 28 days, 71% of subjects in the Peptide E Collagen group showed a significant
                                    decrease in the
                                    number of deep wrinkles. The average deep wrinkle reduction was equal to 10%. On the
                                    other hand, the
                                    control group showed further damage to their skin in the same period with a significant
                                    increase in deep
                                    wrinkles by 28% in 82% of subjects.
                                </p>
                                <p class="text-grey pt-3">
                                    In other words, Peptide E Collagen rebuilds outer skin layers from the inside out and
                                    make your skin
                                    toned, supple and well hydrated while also reducing lines, wrinkles and roughness.
                                </p>
                            </div>
                            <p class="text-darkred pt-3">
                                II. REDUCTION IN SWOLLEN JOINTS IN RHEUMATOID ARTHRITIS
                            </p>
                            <p class="text-grey pt-3">
                                Rheumatoid arthritis is an autoimmune inflammatory disease in which immune T cells react to
                                type II
                                collagen by damaging synovial membrane in the joint. The membrane slowly becomes thicker,
                                destroying
                                cartilage and other joint structures.
                            </p>
                            <p class="text-grey pt-3">
                                In a clinical trial conducted, hydrolyzed collagen reduced the number of swollen and tender
                                joints in
                                patients with severe rheumatoid arthritis. Hydrolyzed collagen is easily digested and
                                absorbed by the
                                body. This, along with its ability to accumulate in cartilage, makes Peptide E Collagen a
                                promising
                                therapy for the treatment of rheumatoid arthritis.
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/II_REDUCTION-IN-SWOLLEN-JOINTS-IN-RHEUMATOID-ARTHRITIS.jpg"
                                    alt="" width="390px" height="363px" class="float-start me-4 mb-4">
                                <p class="text-grey">
                                    Rheumatoid arthritis is an autoimmune inflammatory disease in which the synovial
                                    membrane of the
                                    joint is severely damaged. Type II collagen is the major protein in articular cartilage
                                    and is a
                                    potential auto-antigen to this disease.
                                </p>
                                <p class="text-grey pt-3">
                                    In a randomized, double-blind clinical trial, hydrolyzed collagen was shown to reduce
                                    the number
                                    of swollen and tender joints in patients with severe rheumatoid arthritis. 60 patients
                                    with severe
                                    active rheumatoid arthritis reported a decrease of swollen, tender joints after
                                    consuming chicken
                                    type II collagen for 3 months without any side effects. This effect was not seen in
                                    patients who
                                    received a placebo. Four patients in the collagen group experienced a complete remission
                                    of the
                                    disease.
                                </p>
                            </div>
                            <p class="text-darkred pt-3">
                                III. REDUCTION OF PAIN AND INFLAMMATION IN FIBROMYALGIA
                            </p>
                            <p class="text-grey pt-3">
                                Fibromyalgia is the second most common rheumatologic disease condition after osteoarthritis.
                                Peptide
                                E Collagen actively inhibits pain transmission and reduces the discharge of inflammatory
                                factors and
                                neurotransmitters in the joint.Peptide E Collagen also reduces pain by allowing collagen
                                fibers to
                                reform, improving the overall condition of the cartilage.
                            </p>
                            <p class="text-grey pt-3">
                                Hydrolyzed collagen is also easily digested and absorbed by the body. This, along with its
                                abilities as
                                an analgesic, anti-inflammatory, and cartilage builder, suggests that Peptide E Collagen may
                                be a
                                promising therapy for treating fibromyalgia.
                            </p>
                            <p class="text-grey pt-3">
                                Adding chondroitin sulfate will improve cellular development, while glucosamine will provide
                                cartilage
                                protection and has an additional anti-inflammatory effect.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="hydro-tab-pane" role="tabpanel" aria-labelledby="hydro-tab" tabindex="0">
                    <div class="container-fluid clinicalstudies-bg"
                        style="background-image: linear-gradient(to bottom, rgba(15, 16, 49, 0)   0%, rgba(15, 16, 49, 1.75) 100%), url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/image-00.jpg');">
                        <div class="container">
                            <div class="col-lg-11 mx-auto float-none">
                                <p class="text-white mb-4">
                                    Hydro MN Peptide, the third of Celergen’s essential ingredients, is a marine cartilage
                                    extract with a mix of hydrolyzed proteins <br>
                                    (mainly Collagen) and polysaccharides (35-40% chondroitin sulfate.)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container padding-x">
                        <div class="tab-box bg-white">
                            <p class="text-darkred pt-3">
                                I. PREVENTION OF PHOTOAGING BY PEPTIDE M
                            </p>
                            <p class="text-grey pt-3">
                                Exposure to the sun’s UV radiation is a key factor that causes premature skin aging, known
                                as photo aging,
                                which leads to wrinkles, skin roughness, loss of skin elasticity, and mottled pigmentation.
                            </p>
                            <p class="text-grey pt-3">
                                Peptide M contains the same proteins and polysaccharides as the skin – they act together to
                                improve skin
                                structure,hydration, texture, and elasticity. Over time, fine lines, wrinkles, dilated
                                capillaries, and age
                                spots visibly reduce, reversing sun damage.
                            </p>
                            <p class="text-darkred pt-3">
                                II. EFFECT OF PEPTIDE N ON BLOOD GLUCOSE LEVELS AFTER MEALS
                            </p>
                            <p class="text-grey pt-3">
                                Peptide N, one of Celergen’s ingredients is a marine protein hydrolysate proven to reduce
                                the dietary
                                glycemic index or GI. Peptide N has been shown to prevent unhealthy body fat accumulation
                                while alleviating
                                symptoms of type II diabetes.
                            </p>
                            <p class="text-grey pt-3">
                                Glucose that enters the blood from food is used for energy production in the body’s cells,
                                whereas excess
                                glucose is transformed into fat and stored for later use. Over time this constant storage of
                                fat
                                leads to obesity. Second, frequent sharp, prolonged peaks of blood glucose and insulin (from
                                high GI foods)
                                are known to increase risk for insulin resistance and type II diabetes. On the other hand, a
                                gradual release
                                of blood glucose (from low GI foods) does not affect this risk and also delays hunger pangs.
                            </p>
                            <p class="text-grey pt-3">
                                This figure shows the results of a study evaluating the effects of 4 different proteins –
                                Peptide N, fish fillet, casein milk
                                protein, and soy protein isolate – on blood glucose levels in 17 female volunteers (aged
                                32-64 years). Each volunteer
                                consumed these proteins in random order, always as part of composite meals of similar
                                macronutrient composition with
                                a 1-week gap between each meal.
                            </p>
                            <p class="text-grey pt-3">
                                Blood samples were taken from each volunteer to assess levels of glucose, insulin, and other
                                biomarkers in
                                the fasting state and 7 times after each meal for up to 240 minutes.
                            </p>
                            <p class="text-blue pt-3">
                                BLOOD GLUCOSE RESPONSE AFTER 4 MEALS DIFFERING BY THEIR PROTEIN TYPE CONTENT
                            </p>
                            <div class="clearfix pt-3">
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/clinical_studies/II_EFFECT-OF-PEPTIDE-N-ON-BLOOD-GLUCOSE-LEVELS-AFTER-MEALS1.jpg"
                                    alt="" width="390px" height="363px" class="float-start me-4 mb-4">
                                <p class="text-grey ">
                                    This figure shows the results of a study evaluating the effects of 4 different proteins
                                    – Peptide N, fish fillet, casein milk protein and soy protein isolate – on blood glucose
                                    levels in 17 female volunteers (aged 32-64 years). Each volunteer consumed these
                                    proteins in random order, always as part of composite meals of similar macronutrient
                                    composition with a 1-week gap between each meal.
                                </p>
                                <p class="text-grey pt-3">
                                    Blood samples were taken from each volunteer to assess levels of glucose, insulin and
                                    other biomarkers in the fasting state and 7 times after each meal, for up to 240
                                    minutes.
                                </p>
                                <p class="text-grey pt-3">
                                    This study found that Peptide N supplementation resulted in a significantly blunted
                                    blood glucose
                                    response than with fish fillet protein or soy protein isolate. In other clinical
                                    studies, Peptide N
                                    has been shown to reduce appetite and promote satiety via its actions on metabolic
                                    hormones..
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
