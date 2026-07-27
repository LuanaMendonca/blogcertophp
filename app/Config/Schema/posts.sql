CREATE TABLE posts (
	id SERIAL PRIMARY KEY,
	user_id INTEGER NOT NULL,
	titulo VARCHAR(255) NOT NULL,
	conteudo TEXT NOT NULL,
	status VARCHAR(20) NOT NULL DEFAULT 'ativo',
	created TIMESTAMP NOT NULL,
	modified TIMESTAMP NOT NULL,

	CONSTRAINT fk_posts_users
		FOREIGN KEY (user_id)
		REFERENCES users(id)
);
