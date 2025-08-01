delete from t_answer where ref_question in (select idquestion from t_question where ref_survey=14) and idanswer>10;
delete from t_question where ref_survey=14 and idquestion>8;
delete from t_survey where idsurvey=14;
